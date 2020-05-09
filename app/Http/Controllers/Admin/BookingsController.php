<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\StoreBookingMessageRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Http\Requests\StoreBookingIncidentRequest;
use App\Http\Requests\StoreBookingNoteRequest;
use Dmark\Messenger\Models\Thread;

use App\Http\Controllers\Traits\Common;
use App\Http\Controllers\Traits\BookingProcessTrait;
use App\Http\Controllers\Traits\BookingTrait;
use App\OperationalForms;
use App\Documents;

use App\Provider;
use App\Participant;
use App\RegistrationGroup;
use App\Bookings;
use App\BookingOrders;
use App\SupportWorker;
use App\User;

use Dmark\DMForms\FormService as Form;

use App\Notifications\ServiceBookingCreated;
use App\Notifications\BookingIncidentReport;
use App\Notifications\BookingCompleted;


use App\Events\UpdateFunds;

class BookingsController extends Controller
{
    use Common, BookingProcessTrait, BookingTrait;

    public function __construct() {
        parent::__construct();
    }
    
    public function index(Request $request)
    {
        abort_unless(\Gate::allows('service_booking_access'), 403);

        if ( \Auth::user()->roles()->get()->contains(1) || Gate::allows('onboarding-complete', (Provider::where('user_id', '=', \Auth::user()->id )->firstOrFail()->is_onboarding_complete)) ) {

            $searchMember = $request->query('member');
            $searchStartDate = $request->query('start_date');
            $searchEndDate = $request->query('end_date');

            $bookings = Bookings::searchBookings($request);
            $bookings->load('participant');
            // $bookings->load('serviceProvider');
            // pr($bookings, 1);
            // pr($bookings->toArray(), 1);
            return view('admin.bookings.index', compact('bookings','searchMember','searchStartDate','searchEndDate')); //if onboarding is complete or user is admin
        
        } else{
            return redirect()->route('admin.home')->withErrors( trans('msg.provider.onboarding_pending',['link'=>route('admin.users.profile')]) );
        }
    }

    public function create($editParticipantId=null)
    {
        abort_unless(\Gate::allows('service_booking_create'), 403);

        // $registration_groups = RegistrationGroup::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');
        // $support_workers = SupportWorker::all()->pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        
        
        $participants = Participant::getBookableParticipants()->pluck('full_name', 'user_id')->prepend(trans('global.pleaseSelect'), '');
        
        
        return view('admin.bookings.create', compact('participants','editParticipantId'));
    }

    

    public function edit(int $bookingOrderId)
    {
        abort_unless(\Gate::allows('service_booking_edit'), 403);

        //check if admin (redirect to show view)
        if( checkUserRole('1') )return redirect()->route('admin.bookings.show', [$bookingOrderId]);

        $activeTabInfo = $this->getActiveTab();
        
        $booking = Bookings::where( 'booking_orders.id', $bookingOrderId)->first();

        abort_unless($booking, 404);

        //redirect booking to non editable view if its status is Cancelled,Paid,NotSatisfied,Approved,Submitted,Pending
        // dd($booking);
        $statuses =array( 
                        config('ndis.booking.statuses.Cancelled'),
                        config('ndis.booking.statuses.Paid'),
                        config('ndis.booking.statuses.NotSatisfied'),
                        config('ndis.booking.statuses.Approved'),
                        config('ndis.booking.statuses.Submitted'),
                        config('ndis.booking.statuses.Pending'),
                        config('ndis.booking.statuses.Started'),
                     );
        if( in_array( $booking->status, $statuses ) )
            return redirect()->route('admin.bookings.show',[$bookingOrderId]);
        
        $booking->load('participant', 'registration_group');

        if( $booking->service_type == 'support_worker' ){
            $booking->load('supportWorker');
        }else{
            $booking->load('ServiceProvider');
        }

        // Breakup Start End date into date + start Time + End Time
        $booking->booking_date = Carbon::parse( $booking->starts_at )->format( config('panel.date_input_format') );
        $booking->start_time = Carbon::parse( $booking->starts_at )->format( config('panel.time_format') );
        $booking->end_time = Carbon::parse( $booking->ends_at )->format( config('panel.time_format') );

        // dd($booking, 1);
        
        $request  = new Request();
       
        $request->replace([
                            'service_type' => $booking->service_type,
                            'participant_id' => $booking->participant_id
                        ]);
       
        $editable = ($this->ajax_participant_details($request))->getData();

        // dd($editable);

        return view('admin.bookings.edit', compact('booking', 'activeTabInfo', 'editable'));
    }


    /**
     * Function that saves/update the Booking
     */
    public function ajax_store(StoreBookingRequest $request)
    {
        abort_unless(\Gate::allows('service_booking_create'), 403);
        // dd($request->all());
        try{
        
            $id = $request->input('id');
            $order_id = $request->input('order_id');
            $participant_id = $request->input('participant_id');
            $date = $request->input('date');
            $start_time = $request->input('start_time');
            $end_time = $request->input('end_time');
            $service_type = $request->input('service_type');
            $supp_wrkr_ext_serv_id = $request->input('supp_wrkr_ext_serv_id');
            $is_recurring = intval( $request->input('is_recurring') );

            $starts_at = Carbon::parse(datetimeToDB($date . ' '. $start_time ));
            $ends_at = Carbon::parse(datetimeToDB($date . ' '. $end_time ));

            if(!$is_recurring){
                $request->request->add([
                    'recurring_frequency'=>'none',
                    'recurring_num'=>'none'
                ]);
            }

            $provider = \Auth::user();

            //Adding DB required fields
            $request->request->add([
                                    'starts_at'=> $starts_at,
                                    'ends_at'=> $ends_at,
                                    'status'=>'Scheduled',
                                    'provider_id'=>$provider->id,
                                    ]);
                                    
            $booking = new Bookings;

            //------------------------------------------------------------
            // Check participant's NDIS Plan

                $participant = \App\Participant::with('availability')
                                                ->where('participants_details.user_id',$participant_id)
                                                ->where('participants_details.is_onboarding_complete',1)
                                                ->first();

                
                                                
                // Check if Participant's NDIS plan is valid
                // if( $starts_at->format( config('panel.date_format') ) <= $participant->start_date_ndis )
                // dump('booking_start_date',$starts_at,'plan_start_at',dateCarbon( dateToDB($participant->start_date_ndis) ) ) ;
                // dd($starts_at->lt( dateCarbon( dateToDB($participant->start_date_ndis) ) ) ) ;
                if( $starts_at->lessThan( dateCarbon( dateToDB($participant->start_date_ndis) ) ) )
                    return response()->json([ 'status'=>false, 'message'=>trans('msg.bookings.participant.ndis_starts_on', ['start_date'=>$participant->start_date_ndis]) ]);
                

                // pr( dateCarbon( dateToDB($participant->end_date_ndis)), 1 );

                // dd($ends_at,dateCarbon( dateToDB($participant->end_date_ndis) ) );       
                
                // if(  dateCarbon( dateToDB($participant->end_date_ndis) )->lessThan($ends_at) )
                // dump('booking_end_date',$ends_at,'plan_ends_at',dateCarbon( dateToDB($participant->end_date_ndis) ) ) ;
                // dump($ends_at->gt( dateCarbon( dateToDB($participant->end_date_ndis) ) ) ) ;
                if(  $ends_at->gt( dateCarbon( dateToDB($participant->end_date_ndis) ) ) )
                    return response()->json([ 'status'=>false, 'message'=>trans('msg.bookings.participant.ndis_expired_on', ['end_date'=>$participant->end_date_ndis]) ]);

            //------------------------------------------------------------
            // Check for Participant's Availability

                // check if Participant is available in the given time frame
                $range = strtolower($starts_at->format('l'));

                $range_data = $participant->getAvailabilityForRange($range);
                // pr($participant);
                if(!$range_data)
                    return response()->json([ 'status'=>false, 'message'=>trans('msg.bookings.participant.not_available_on_day') ]);
                
                $range_start = Carbon::parse( $starts_at->format( config('panel.date_format') ) . ' '. $range_data->from );
                $range_end = Carbon::parse( $ends_at->format( config('panel.date_format') ) . ' '. $range_data->to );

                if( $starts_at->lessThan($range_start) || $ends_at->greaterThan($range_end) )
                    return response()->json([ 'status'=>false, 'message'=> trans('msg.bookings.participant.only_available_on', [ 'from'=>$range_data->from, 'to'=>$range_data->to ])  ]);
                

                //also check if Participant has any other booking on the given date time?

                    $particiapntBooking = $booking->participantBookingsBetween( $participant_id, $request->input('starts_at'), $request->input('ends_at') ,$order_id);
                    // pr($particiapntBooking, 1);
                    if($particiapntBooking)
                        return response()->json([ 'status'=>false, 'message'=>trans('msg.bookings.participant.already_booked') ]);
                
                
            // End of Check for Participant's Availability
            //------------------------------------------------------------
                

            //------------------------------------------------------------
            // Check for Support Worker's Availability

                if($service_type == 'support_worker'){
                    $swBooking = $booking->swBookingsBetween( $supp_wrkr_ext_serv_id, $request->input('starts_at'), $request->input('ends_at') );
                    // pr($swBooking, 1);
                    if($swBooking)
                        return response()->json([ 'status'=>false, 'message'=>trans('msg.bookings.sw.already_booked') ]);
                }

            // End of Check for Support Worker's Availability
            //------------------------------------------------------------
            
            // pr( $request->all(), 1 );

            if($id && $order_id){
                $booking_order = BookingOrders::find($order_id);
                $booking = $booking_order->booking;
            }

            //update booking
            if($booking->id){
                // pr( $request->all(), 1 );
                $booking->update($request->all());
                $booking_order->update($request->all());
                
                event( new UpdateFunds( 
                                    array(
                                            'order_id'=>$order_id,                                                                                
                                            'type' =>'update'
                                        )
                                )
                );

                $booking->load('orders');
                return response()->json([ 'status'=>true, 'message'=>trans('msg.bookings.update_success') ]);
            }
            //create booking
            else{
                
                $booking = $booking->create($request->all());
                $request->request->add([ 'booking_id' => $booking->id ]);

                if($is_recurring){
                    
                    $recurring_frequency = $request->input('recurring_frequency');
                    $recurring_num = intval($request->input('recurring_num'));
                    
                    //First Add the given Date's Booking Order
                    $booking_order = \App\BookingOrders::create( $request->all() );
                    $updateFunds = event( new UpdateFunds( 
                                    array(                                                  
                                            'order_id'=> $booking_order->id,
                                            'type' =>'create'
                                        )
                                    )
                    );

                    // Now add Recurring Orders
                    for($i=0; $i<($recurring_num -1); $i++){
                        switch ($recurring_frequency) {
                            case 'daily':
                                $starts_at = $starts_at->addDay();
                                $ends_at = $ends_at->addDay();
                                break;
                            case 'weekly':
                                $starts_at = $starts_at->addWeek();
                                $ends_at = $ends_at->addWeek();
                                break;
                            case 'fortnightly':
                                $starts_at = $starts_at->addWeeks(2);
                                $ends_at = $ends_at->addWeeks(2);
                                break;
                            case 'monthly':
                                $starts_at = $starts_at->addMonth();
                                $ends_at = $ends_at->addMonth();
                                break;
                            case 'yearly':
                                $starts_at = $starts_at->addYear();
                                $ends_at = $ends_at->addYear();
                                break;
                        }
                        $request->request->add([
                                        // 'starts_at'=>$starts_at->format( config('panel.db_datetime_format') ),
                                        'starts_at'=>$starts_at,
                                        'ends_at'=>$ends_at,
                                        // 'ends_at'=>$ends_at->format( config('panel.db_datetime_format') ),
                                        ]);

                        $booking_order = \App\BookingOrders::create( $request->all() );

                        $updateFunds = event( new UpdateFunds( 
                                            array(                                                  
                                                    'order_id'=> $booking_order->id,
                                                    'type' =>'create'
                                                 )
                                        )
                        );
                        
                    }
                    
                }else{
                    
                    $booking_order = \App\BookingOrders::create($request->all());               

                    $updateFunds = event( new UpdateFunds( 
                                            array(                                                  
                                                    'order_id'=> $booking_order->id,
                                                    'type' =>'create'
                                                 )
                                        )
                        );

                    // dd($updateFunds);
                }
                
                $participant = \App\User::find($participant_id);
                $supp_wrkr_ext_serv = \App\User::find($supp_wrkr_ext_serv_id);

                //Send Notification to the participant 
                $participant->notify(new ServiceBookingCreated( $booking_order, $participant, $provider, $supp_wrkr_ext_serv, 'participant'));

                //Send Notification to the Support Worker
                $supp_wrkr_ext_serv->notify(new ServiceBookingCreated( $booking_order, $participant, $provider, $supp_wrkr_ext_serv, 'worker'));
                
                // dd($booking_order->booking);

                //Create a Task here for the Service Booking

                return response()->json([ 'status'=>true, 'message'=>trans('msg.bookings.create_success') ]);
            }
        }
        catch(Exception $e){
            return response()->json([ 'status'=>false, 'message'=>$e->getMessage() ]);
        }
    }


    public function update(UpdateBookingRequest $request, Bookings $booking)
    {
        abort_unless(\Gate::allows('service_booking_edit'), 403);

        $booking->update($request->all());

        return redirect()->route('admin.bookings.index');
    }

    public function show(Request $request, $id)
    {
        abort_unless(\Gate::allows('service_booking_show'), 403);

        $booking = Bookings::where( 'booking_orders.id', $id)->first();

        $booking->load('participant', 'registration_group','supportWorker');
        //  dd($booking);

        return view('admin.bookings.show', compact('booking'));
    }

    public function destroy(Bookings $booking)
    {
        abort_unless(\Gate::allows('service_booking_delete'), 403);

        BookingOrders::where('booking_id', $booking->id)->delete();
        $booking->delete();

        return back();
    }



    /***
     * 
     */
    public function note($bookingOrderId){

        abort_unless(\Gate::allows('service_booking_edit'), 403);

        $activeTabInfo = $this->getActiveTab();

        $booking = Bookings::where( 'booking_orders.id', $bookingOrderId)->first();
        
        abort_unless($booking, 404, "Booking not found!");

        $booking->load('notes');
        // pr($booking, 1);

        return view( 'admin.bookings.edit', compact('booking', 'activeTabInfo') );
    }

    public function ajax_note_save( StoreBookingNoteRequest $request, $bookingOrderId){
        abort_unless(\Gate::allows('service_booking_edit'), 403);

        $provider = \Auth::user();

        $activeTabInfo = $this->getActiveTab();
        $bookingOrder = BookingOrders::without('booking')->where( 'booking_orders.id', $bookingOrderId)->first();
        abort_unless($bookingOrder, 404, "Booking not found!");

        $request->request->add([
            "title" => "Note by #".$provider->id,
            'type' => 'booking',
            'relation_id' => $bookingOrder->id,
            'created_by' => $provider->id,
            'provider_id' => $provider->id,
        ]);

        $note = \App\Notes::create( $request->all() );
        
        return redirect()->route("admin.bookings.edit.note", [$bookingOrder->id])->with('success', trans('msg.note_created'));

    }

    /**
     * Display Participant Messages for Booking
     */
    public function contact_participant($bookingOrderId){

        abort_unless(\Gate::allows('service_booking_edit'), 403);

        $activeTabInfo = $this->getActiveTab();

        $bookingOrder = BookingOrders::find($bookingOrderId);
        $booking = $bookingOrder->booking;
        
        abort_unless($bookingOrder, 404, "Booking not found!");

        $thread = Thread::find( $bookingOrder->msgThreadForUsers( [auth()->user()->id, $booking->participant_id] ) );
        $bookingOrder->messages = ($thread)?$thread->first()->messages:[];
        
        // pr($bookingOrder, 1);

        return view( 'admin.bookings.edit', compact('bookingOrder', 'booking', 'activeTabInfo') );

    }

    public function contact_participant_save(StoreBookingMessageRequest $request, $booking_order_id){

        abort_unless(\Gate::allows('service_booking_edit'), 403);

        $message = $request->input('message');
        
        $bookingOrder = BookingOrders::find($booking_order_id);
        
        $provider = \Auth::user();
        $participant = User::find( $bookingOrder->booking->participant_id );

        $message = $bookingOrder->sendBookingMessage( $participant, $message, $provider );

        return redirect()->route("admin.bookings.edit.contact.participant", [$booking_order_id])->with('success', trans('msg.message.sent_success'));

    }

    /**
     * Display Support Worker Messages for Booking
     */
    public function contact_worker($bookingOrderId){

        abort_unless(\Gate::allows('service_booking_edit'), 403);

        $activeTabInfo = $this->getActiveTab();

        $bookingOrder = BookingOrders::find($bookingOrderId);
        $booking = $bookingOrder->booking;

        abort_unless($booking, 404, trans('msg.bookings.not_found') );

        if($booking->service_type !== "support_worker"){
            abort_unless($booking, 404, trans('msg.bookings.not_found') );    
        }

        $thread = Thread::find( $bookingOrder->msgThreadForUsers( [auth()->user()->id, $booking->supp_wrkr_ext_serv_id] ) );
        $bookingOrder->messages = ($thread)?$thread->first()->messages:[];

        return view( 'admin.bookings.edit', compact('bookingOrder', 'booking', 'activeTabInfo') );
        
    }

    public function contact_worker_save(StoreBookingMessageRequest $request, $booking_order_id){

        abort_unless(\Gate::allows('service_booking_edit'), 403);

        $bookingOrder = BookingOrders::find($booking_order_id);

        $message = $request->input('message');
        
        $bookingOrder = BookingOrders::find($booking_order_id);
        
        $provider = \Auth::user();
        $supportWorker = User::find( $bookingOrder->booking->supp_wrkr_ext_serv_id );
        
        $message = $bookingOrder->sendBookingMessage( $supportWorker, $message, $provider );

        return redirect()->route("admin.bookings.edit.contact.worker", [$bookingOrder->id])->with('success', trans('msg.message.sent_success') );

    }

   

    public function invoice( $bookingOrderId ){
        
        abort_unless(\Gate::allows('service_booking_edit'), 403);

        $activeTabInfo = $this->getActiveTab();

        $booking = Bookings::where( 'booking_orders.id', $bookingOrderId)->first();
        
        abort_unless($booking, 404, "Booking not found!");

        return view( 'admin.bookings.edit', compact('booking', 'activeTabInfo') );

    }

    public function invoice_save($bookingId){

    }


    
    public function incident( $bookingOrderId ){

        abort_unless(\Gate::allows('service_booking_edit'), 403);

        $activeTabInfo = $this->getActiveTab();

        $booking = Bookings::where( 'booking_orders.id', $bookingOrderId)->first();

        abort_unless($booking, 404, "Booking not found!");

        $booking->load('incident');

        return view( 'admin.bookings.edit', compact('booking', 'activeTabInfo') );
    }

    public function incident_save(StoreBookingIncidentRequest $request){

        abort_unless(\Gate::allows('service_booking_edit'), 403);
        
        $booking_order_id = $request->input('booking_order_id');

        $booking = BookingOrders::find($booking_order_id);

        abort_unless($booking, 404, "Booking not found!");

        $provider = \Auth::user();


        //create or update opforms and op_meta data
        $opform = OperationalForms::updateOrCreate(
            ['user_id' => request('user_id'), 'provider_id' => $provider->id, 
            'template_id' => request('template_id')],
            ['title' => 'Incident Report Form', 'date' => today()]
        );

        $meta_array = [];

        if($opform->id) {
            DB::table('opforms_meta')->where('opform_id', $opform->id)->delete();
        }

        foreach($request->all() as $key=>$value) {

            if($key == 'incident_details' || $key == 'any_injuries' || $key == 'any_damage' || $key == 'cause_of_incident' || $key == 'actions_to_eliminate' || $key == 'management_comments') {
                $meta = ['opform_id'=>$opform->id];
                $meta['meta_key'] = $key;
                $meta['meta_value'] = $value;
                $meta_array[] = $meta;
            }
        }

        $opform->meta()->insert($meta_array);

        //end of opform incident create code

        //Adding DB required fields
        $request->request->add([
            'datetime'=> Carbon::now(),
            'created_by'=>$provider->id,
            'provider_id'=>$provider->id,
            ]);
        
        $booking->load('participant');
        $participant = $booking->participant;
        if($booking->service_type == 'support_worker'){
            $booking->load('supportWorker');
            $supportWorker = $booking->supportWorker;
        }


        $incident = \App\BookingIncidents::where('booking_order_id',$booking_order_id)->first();
        
        if($incident){
            $incident->update($request->all());
            return redirect()->route("admin.bookings.edit.incident", [$booking->id])->with('success', trans('msg.bookings.incident_update_success') );
        }else{
            $incident = \App\BookingIncidents::create( $request->all() );

            $incident->url = route("admin.bookings.edit.incident.save", [$booking->id]);

            //Send Notification to the Support Worker
            $participant->notify(new BookingIncidentReport( $provider, $incident));
            
            if($booking->service_type == 'support_worker')
                $supportWorker->notify(new BookingIncidentReport( $provider, $incident));
        }

        return redirect()->route("admin.bookings.edit.incident", [$booking->id])->with('success', trans('msg.bookings.incident_create_success') );

    }



    public function manuallyCompleteList(){
        abort_unless(\Gate::allows('service_booking_show'), 403);
        $bookings = Bookings::where('booking_orders.status','=',config('ndis.booking.statuses.NotSatisfied'))->get();

        return view( 'admin.bookings.manually_complete_list', compact('bookings') );
    }

    public function manuallyCompleteShow( $booking_order_id){
        abort_unless(\Gate::allows('service_booking_edit'), 403);

        try{
            $booking_order = \App\BookingOrders::whereId($booking_order_id)
                                            ->where('booking_orders.status','=',config('ndis.booking.statuses.NotSatisfied'))
                                            ->first();

            $movedToAccounts = \App\BookingOrders::whereId($booking_order_id)
                                            ->whereIn('booking_orders.status', [ config('ndis.booking.statuses.Submitted'),config('ndis.booking.statuses.Paid'),config('ndis.booking.statuses.Pending')])
                                            ->first();

            //if booking dont have NotStatisfied status anymore
            if( ! $booking_order && $movedToAccounts ){
                return back()->withErrors(['Booking is moved to Accounts module.']);
            }
            
            //dd($booking_order->booking_id);
            $booking_order->load('meta');
            $meta = [];
            foreach( $booking_order->meta as $key=>$val){
                $meta[$val->meta_key] = $val->meta_value;
            }
            
            $bookingInformation = Bookings::where('bookings.id', $booking_order->booking_id)->first();
            
            // dd($booking_order->toArray());
            if($bookingInformation->service_type == 'support_worker'){
                return view( 'admin.bookings.manually_complete', compact('booking_order','meta') );
            }else if($bookingInformation->service_type == 'external_service'){
                return view( 'admin.bookings.manually_complete_external', compact('booking_order','meta','bookingInformation') );
            }
        }
        catch(Exception $error){
            return back()->withError($error->message());
        }
        

       
        
        
        
    }

    public function manuallyComplete( $booking_order_id, Request $request){
        abort_unless(\Gate::allows('service_booking_edit'), 403);   
        
        $swRate = null;
        $providerRate = null;
        $metaArray = [];
        $booking_order = \App\BookingOrders::find($booking_order_id);
        $booking_order->load('meta');
        $booking_order->load('booking');
        // $participant_id = $request->input('participant_id');
        $participant_id = $booking_order->booking->participant_id;
        
        if($request->input('booking_quote_required')):
            $messages = [
                    'booking_manual_total_amount'   => "Booking instance ID is required!",
                    'booking_manual_quote_amount'   => "Booking instance ID is required!",                  
                ];
            $data = Validator::make( $request->all(), [
                                                        'booking_manual_total_amount' => 'required | numeric',
                                                        'booking_manual_quote_amount' => 'required | numeric',
                                                    ], $messages);
            // dd(collect(json_decode($data->messages()))->flatten());
            if($data->fails()):                
                $message ="";
                foreach(collect(json_decode($data->messages()))->flatten() as $i=>$m):
                    $message .= $m;
                endforeach;
                
                return redirect()->route("admin.bookings.manually-complete.show",$booking_order_id)->with('message', $message);
            endif;
            $swRate = $request->input('booking_manual_quote_amount');
            $providerRate = $request->input('booking_manual_total_amount');            
        endif;

        //upload external support worker document
        if($request->hasFile('document') && $participant_id)
        {
            try {

                $file = $request->file('document');
                $provider = \Auth::user();

                $file_id = Documents::saveDoc( $file, [ 
                                        'title'=>$request->input('booking_order_id').'_external_document',
                                        'user_id'=>$participant_id, 
                                        'provider_id'=>$provider->id
                                        ]);
                
                if($file_id){
                    $metaArray[] = [
                                    'booking_order_id' => $booking_order_id,
                                    'meta_key' => config('ndis.booking.manual.meta_key.external_invoice'),
                                    'meta_value' => $file_id->id
                                    ];
                }
            }
            catch(Exception $error){
                return back()->withError($error->message());
            }

        }
        // dd($booking_order_id,$request->all());

        $comment = $request->input('booking_manual_comment');       

        $timesheet = $this->addApprovdBookingInTimesheet( $booking_order_id, $swRate, $providerRate );
        
        if( $timesheet['status'] ){
            
            $metaArray[] = [
                'booking_order_id' => $booking_order_id,
                'meta_key' => config('ndis.booking.manual.meta_key.comment'),
                'meta_value' => $comment ? $comment : '' 
                ];

            $booking_order->meta()->create($metaArray);
            
            //set booking status to Approved and save
            $booking_order->status = config('ndis.booking.statuses.Approved');
            $booking_order->save();
 
            //Send notifications to users
            (User::find($participant_id))->notify( new BookingCompleted(  $booking_order, 'participant' ) );
            (User::find($booking_order->booking->supp_wrkr_ext_serv_id))->notify( new BookingCompleted(  $booking_order, 'worker' ) );
    

            return redirect()->route("admin.bookings.manually-complete.list")->with('success', trans('msg.bookings.approved') );
        }else{

            return redirect()->route("admin.bookings.manually-complete.show",$booking_order_id)->with('message', trans('errors.general_error') );
        }       

    }



    //------------------------------------------------------------------------------------------
    // Helper Functions
    //------------------------------------------------------------------------------------------
    private function getActiveTab(){
        
        $activeTabInfo = [ 'tab'=>'edit', 'file'=>"admin.bookings.edit_index", "title" => trans('participants.tabs.details') ];

        if ( request()->is('admin/bookings/*/note') ):
            
            $activeTabInfo = [ 'tab'=>'note', 'file'=>"admin.bookings.edit_note", "title" => trans('participants.tabs.details') ];

        elseif ( request()->is('admin/bookings/*/contact/participant') ):
            
            $activeTabInfo = [ 'tab'=>'contact_participant', 'file'=>"admin.bookings.edit_contact_participant", "title" => trans('documents.title') ];
        
        elseif ( request()->is('admin/bookings/*/contact/worker') ):
            
            $activeTabInfo = [ 'tab'=>'contact_worker', 'file'=>"admin.bookings.edit_contact_worker", "title" => trans('documents.new_document') ];

        elseif ( request()->is('admin/bookings/*/invoice') ):
            
            $activeTabInfo = [ 'tab'=>'invoice', 'file'=>"admin.bookings.edit_invoice", "title" => trans('participants.tabs.availability') ];

        elseif ( request()->is('admin/bookings/*/incident') ):
            
            $activeTabInfo = [ 'tab'=>'incident', 'file'=>"admin.bookings.edit_incident", "title" => trans('participants.tabs.bookings') ];

        endif;

        return $activeTabInfo;
    }



}