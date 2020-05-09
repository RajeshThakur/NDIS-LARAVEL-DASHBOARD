<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreParticipantRequest;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\StoreNotesRequest;
use App\Http\Requests\UpdateParticipantRequest;
// use App\Http\Requests\StoreAvailabilityRequest;
use App\Http\Controllers\Traits\Common;

use App\User;
use App\Participant;
use App\UsersToProviders;
use App\OperationalForms;
use App\Bookings;
use App\Documents;
use App\Notes;
use App\Availability;

use Notification;
use App\Notifications\UserActivation;

class ParticipantsController extends Controller
{
    use Common;
        
    public function __construct()
    {
        // then execute the parent constructor anyway
        parent::__construct();
        
    }

    public function index( Request $request )
    {
        abort_unless(\Gate::allows('participant_access'), 403);
        //dd($request);
        $dd = Common::getDropDown();
        // $participants = Participant::with('user')->get();
        // $participants = User::with('participant')->with('UserProvider')->get();

        $query = "";
        if($request->query('q'))
            $query = $request->query('q');
        
        $participants = Participant::providerParticipants( $query );

        // pr($participants, 1);
        return view('admin.participants.index', compact('participants', 'dd', 'query'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('participant_create'), 403);

        return view('admin.participants.create');
    }

    /**
     * Function to Store User and Participant
     */
    public function store(StoreParticipantRequest $request)
    {
        abort_unless(\Gate::allows('participant_create'), 403);
        
        //Set Default Fields for DB to save. Setting Password empty as User will have to reset password!
        $request->request->add([ 'password'=>'empty' ]);

        $user = User::where('email', $request->input('email') )->first();

        if( !isset( $user->id ) ){
            $user = User::create( $request->all() );
            $user->roles()->sync([3]);
        }

        $participant = new Participant;
        $participant->user_id = $user->id;
        $participant->address = $request->input('address');
        $participant->lat = $request->input('lat');
        $participant->lng = $request->input('lng');
        $participant->start_date_ndis = $request->input('start_date_ndis');
        $participant->end_date_ndis = $request->input('end_date_ndis');
        $participant->ndis_number = $request->input('ndis_number');
        $participant->special_requirements = $request->input('special_requirements');

        // pr($participant, 1);
        
        $user->participant()->save($participant);
        //Set default Participant Role

        $provider = \Auth::user();
        $user2Provider = new UsersToProviders;
        $user2Provider->user_id = $user->id;
        $user2Provider->provider_id = $provider->id;
        $user->UserProvider()->save($user2Provider);
        
        //Send Notification to the Participant
        $user->notify(new UserActivation($user));
        
        return redirect()->route('admin.participants.edit', $participant->id)->with('success',trans('msg.participant.success') );
    }


    public function edit(Participant $participant)
    {

        abort_unless(\Gate::allows('participant_edit'), 403);

        //check if admin (redirect to show view)
        if( checkUserRole('1') )return redirect()->route("admin.participants.show", [$participant->id]);


        //Fetch User data
        $operationFormFill = [];

        $activeTabInfo = $this->getActiveTab();

        // dd($participant->onboarding_step);

        $operationFormFill = $this->check_steps($participant);

        // dd($operationFormFill);

        return view( 'admin.participants.edit', compact('participant', 'activeTabInfo', 'operationFormFill') );
    }

    public function update(UpdateParticipantRequest $request, Participant $participant)
    {
        abort_unless(\Gate::allows('participant_edit'), 403);

        $participant->update(
                        $request->only(['address','lat','lng','ndis_number','start_date_ndis','end_date_ndis','participant_goals','special_requirements'])
                    );
        
        // pr($participant);
        // pr($request->all(), 1);

        
        //Update User as well
        $user = User::find( $request->input('user_id') );

        $user->update([
            'first_name'=>$request->input('first_name'),
            'last_name'=>$request->input('last_name'),
            'email'=>$request->input('email')
        ]);

        return redirect()->route('admin.participants.index');
    }


    //------------------------------------------------------------------------------------------
    // Wizard Section

    public function onboarding( $participantId )
    {
        abort_unless(\Gate::allows('participant_edit'), 403);
        
        $participant = new Participant;
        
        //Fetch User data
        $participant = $participant->getParticipant($participantId);

        abort_unless($participant, 404, "Invalid Participant!");
        
        $activeTabInfo = $this->getActiveTab();

        return view( 'admin.participants.edit', compact('participant', 'activeTabInfo') );
    }

    //------------------------------------------------------------------------------------------
    // Documents Section

    public function documents( $participantId )
    {
        abort_unless(\Gate::allows('participant_edit'), 403);
        
        $participant = new Participant;
        
        //Fetch User data
        $participant = $participant->getParticipant($participantId);

        abort_unless($participant, 404, "Invalid Participant!");

        $participant->documents = Documents::getParticipantDocuments($participantId);

        $opforms = OperationalForms::participant( $participantId )->get();
        
        $activeTabInfo = $this->getActiveTab();

        $operationFormFill = $this->check_steps($participant);

        return view( 'admin.participants.edit', compact('participant', 'opforms',  'activeTabInfo','operationFormFill') );
    }


    public function document_new( $participantId )
    {
        abort_unless(\Gate::allows('participant_edit'), 403);
        
        $participant = new Participant;
        
        //Fetch User data
        $participant = $participant->getParticipant($participantId);

        abort_unless($participant, 404, "Invalid Participant!");

        $activeTabInfo = $this->getActiveTab();
        
        return view( 'admin.participants.edit', compact('participant', 'activeTabInfo') );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function document_save( StoreDocumentRequest $request, $participantId )
    {

        abort_unless(\Gate::allows('participant_edit'), 403);
        
        $participant = new Participant;
        
        //Fetch User data
        $participant = $participant->getParticipant($participantId);

        abort_unless($participant, 404, "Invalid Participant!");

        

        if($request->hasFile('document'))
        {
            try{
                $file = $request->file('document');
                $provider = \Auth::user();

                $fileInfo = Documents::saveDoc( $file, [ 
                                                        'title'=>$request->input('title'),
                                                        'user_id'=>$participant->user_id, 
                                                        'provider_id'=>$provider->id
                                                        ]);

                return redirect()->route("admin.participants.documents", [$participant->user_id])->withSuccess('Document added successfully!');
            }
            catch(Exception $error){
                return back()->withError($error->message());
            }

        }

        return back()->withError('Document is missing');
        
    }


    //------------------------------------------------------------------------------------------
    // Availability Section

    public function availability( $participantId )
    {
        abort_unless(\Gate::allows('participant_edit'), 403);
        
        $participant = new Participant;
        
        //Fetch User data
        $participant = $participant->getParticipant($participantId);
        $provider = \Auth::user();

        abort_unless($participant, 404, "Invalid Participant!");

        $availabilities = Availability::where('user_id',$participant->user_id)->get();

        $availabiltyRange = ['monday'=>'Monday', 'tuesday'=>'Tuesday', 'wednesday'=>'Wednesday', 'thursday'=>'Thursday', 'friday'=>'Friday', 'saturday'=>'Saturday', 'sunday'=>'Sunday'];

        if(!count($availabilities)){
            
            // $availabilities = [];
            // foreach($availabiltyRange as $range){
            //     $avail = new Availability;
            //     $avail->range = $range;
            //     $availabilities[] = $avail;
            // }
        }
        // pr($availabilities);

        $operationFormFill = $this->check_steps($participant);

        $activeTabInfo = $this->getActiveTab();
        return view( 'admin.participants.edit', compact('participant', 'activeTabInfo', 'availabilities','availabiltyRange','operationFormFill') );
    }

    //------------------------------------------------------------------------------------------
    // Bookings Section

    public function bookings( $participantId , Request $request)
    {
        abort_unless(\Gate::allows('participant_edit'), 403);

        $participant = new Participant;
        //Fetch User data
        $participant = $participant->getParticipant($participantId);

        abort_unless($participant, 404);

        // get supportworkers/externals  from bookings
        // $participant->load('bookings');
        $bookings = Bookings::where([
                                        // ['provider_id', '=', \Auth::user()->id],
                                        ['participant_id', '=', $participant->user_id],
                                    ])
                                    ->get();
        // pr($participantId, 1);
        $swFromBookings = User::whereIn('id',($bookings->pluck('supp_wrkr_ext_serv_id')->toArray()))->get();
        global $sw ;
        if( !($swFromBookings->isEmpty()) ){
            $swFromBookings->map(function ($item, $key) {
                global $sw;
                $sw[$item['id']] = $item['first_name'] ." ". $item['last_name'] ." (".$item['email'].")";
            });
            $participant->sw = array_unique($sw);           
        }
        $sw = null;
        // pr($request->all());
        if( !empty( $request->input('member') ) || !empty( $request->input('start_date') ) || !empty( $request->input('end_date') ) ){
            
            $v = $request->validate([
                'start_date' => 'bail|required| date',
                'end_date' => 'bail|required| date',
                'member' => 'bail|required| integer| not_in:0',
            ]);
            $participant->bookings = Bookings::leftJoin('booking_orders','bookings.id','=','booking_orders.booking_id')
                                                    ->whereDate('booking_orders.starts_at', '>=', $request->get('start_date'))
                                                    ->whereDate('booking_orders.ends_at', '<=', $request->get('end_date'))
                                                    ->where([
                                                            // ['provider_id', '=', \Auth::user()->id],
                                                            ['participant_id', '=', $participant->user_id],
                                                            ['supp_wrkr_ext_serv_id', '=', $request->input('member')],
                                                        ])
                                                    ->get();
            // pr( $participant,1 );
           
        }else{
            $participant->bookings = $bookings;
        }

        // pr($participant,1);

        abort_unless($participant, 404, "Invalid Participant!"); 

        $operationFormFill = $this->check_steps($participant);

        $activeTabInfo = $this->getActiveTab();

        
        return view( 'admin.participants.edit', compact('participant', 'activeTabInfo','operationFormFill') );
    }



    //------------------------------------------------------------------------------------------
    // Bookings Section

    public function notes( $participantId )
    {
        abort_unless(\Gate::allows('participant_edit'), 403);
        
        $participant = new Participant;
        
        //Fetch User data
        $participant = $participant->getParticipant($participantId);

        abort_unless($participant, 404, "Invalid Participant!");
        
        $participant->notes = Notes::getUserNotes($participantId);

        $activeTabInfo = $this->getActiveTab();

        $operationFormFill = $this->check_steps($participant);

        return view( 'admin.participants.edit', compact('participant', 'activeTabInfo','operationFormFill') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notes_save( StoreNotesRequest $request, $participantId )
    {

        abort_unless(\Gate::allows('participant_edit'), 403);
        
        $participant = new Participant;
        
        //Fetch User data
        $participant = $participant->getParticipant($participantId);

        abort_unless($participant, 404, "Invalid Participant!");

        $user = \Auth::user();

        $note = new Notes();
        $note->title = $request->input('title');
        $note->description = $request->input('description');
        $note->type = 'participant';
        $note->relation_id = $request->input('user_id');
        $note->provider_id = $user->id;
        $note->created_by = $user->id;
        $note->save();

        return redirect()->route("admin.participants.notes", [$participant->user_id])->with('message', 'Note saved successfully!');
    }



    //------------------------------------------------------------------------------------------
    // Helper Functions
    //------------------------------------------------------------------------------------------
    private function getActiveTab(){
        
        $activeTabInfo = [ 'tab'=>'edit', 'file'=>"admin.participants.edit_index", "title" => trans('participants.tabs.details') ];

        if ( request()->is('admin/participants/*/onboarding') ):
            
            $activeTabInfo = [ 'tab'=>'edit', 'file'=>"admin.participants.edit_index", "title" => trans('participants.tabs.details') ];

        elseif ( request()->is('admin/participants/*/documents') ):
            
            $activeTabInfo = [ 'tab'=>'documents', 'file'=>"admin.participants.edit_documents", "title" => trans('documents.title') ];
        
        elseif ( request()->is('admin/participants/*/documents/new') ):
            
            $activeTabInfo = [ 'tab'=>'documents', 'file'=>"admin.participants.create_documents", "title" => trans('documents.new_document') ];

        elseif ( request()->is('admin/participants/*/availability') ):
            
            $activeTabInfo = [ 'tab'=>'availability', 'file'=>"admin.participants.edit_availability", "title" => trans('participants.tabs.availability') ];

        elseif ( request()->is('admin/participants/*/bookings') ):
            
            $activeTabInfo = [ 'tab'=>'bookings', 'file'=>"admin.participants.edit_bookings", "title" => trans('participants.tabs.bookings') ];

        elseif ( request()->is('admin/participants/*/notes') ):
            
            $activeTabInfo = [ 'tab'=>'notes', 'file'=>"admin.participants.edit_notes", "title" => trans('participants.tabs.notes') ];

        endif;

        return $activeTabInfo;
    }



    //------------------------------------------------------------------------------------------
    //
    //------------------------------------------------------------------------------------------

    public function show(Participant $participant)
    {
        abort_unless(\Gate::allows('participant_show'), 403);

        //Fetch User data
        $participant->user = $participant->user()->first();

        return view('admin.participants.show', compact('participant'));
    }

    public function destroy($participantId)
    {
        abort_unless(\Gate::allows('participant_delete'), 403);
        $deleted = false;

        // \DB::enableQueryLog();
        
        $participant = Participant::find($participantId);
        if($participant)
            $deleted = $participant->delete();

        $user = User::find($participant->user_id);
        if($user)
            $deleted = $user->delete();
            

        // $query = \DB::getQueryLog();
        // pr(end($query),1);

        if ($deleted) {
            return redirect()->route("admin.participants.index")->with('message',trans('msg.participant.message') );
        } else {
            redirect()->route("admin.participants.index")->with('message:error', 'Unable to delete Record');
        }
        
    }





    public function onboarding_steps( Request $request )
    {

        $step = $request->input('step');

        $operationFormFill = [];    

        
        switch( intval($step) ){
            case 1:

                $data = $request->validate([
                                            'have_gps_phone' => 'required',
                                            'using_guardian' => 'required',
                                            'user_id' => 'required',
                                            'step' => 'required'
                                        ]);

                $participant = new Participant;

                //Fetch User data
                $participant = $participant->getParticipant( $data['user_id'] );

                if( !$participant ){
                    return [ 'status'=>false, 'message'=>'Invalid Submission! please try again later.' ];
                }

                $next_step = 2;

                //Update the Participant with given values
                $participant->where('participants_details.user_id', $participant->user_id)->update([
                    'have_gps_phone' => $request->input('have_gps_phone'),
                    'using_guardian' => $request->input('using_guardian'),
                    'onboarding_step'=> $next_step
                ]);

                if($request->input('using_guardian')){
                    $guardianformId = 1;
                    $guardianformUrl = route("admin.forms.create", [$guardianformId, $participant->user_id, $isParticipantTrue=1]);
                    return [ 'status'=>true, 'type'=>'redirect', 'next_step'=>$next_step, 'redirect_url'=>$guardianformUrl  ];
                }

                return [ 'status'=>true, 'type'=>'popup', 'next_step'=>$next_step ];

            break;

            case 2:
                
                $data = $request->validate([
                                                'provider_agreement' => 'required',
                                                'user_id' => 'required',
                                                'step' => 'required'
                                            ]);

                $participant = new Participant;

                //Fetch User data
                $participant = $participant->getParticipant( $data['user_id'] );
                
                
                $opFormObj = OperationalForms::where('user_id', $participant['user_id'])
                                            ->whereIn('template_id', [2, 3, 10])
                                            ->get()
                                            ->pluck('template_id');
        
                foreach($opFormObj as $key=>$value) {
        
                    if($value == 2) {
                        $operationFormFill['care_plan'] = true;
                    }
                    if($value == 3) { 
                        $operationFormFill['client_consent_form'] = true;
                    }
                    if($value == 10) {
                        $operationFormFill['risk_assessment'] = true;
                    }
                } 



                if( !$participant ){
                    return [ 'status'=>false, 'message'=>'Invalid Submission! please try again later.' ];
                }

                $next_step = 3;
                    
                    //Update the Participant with given values
                $participant->where('participants_details.user_id', $participant->user_id)->update([ 'onboarding_step'=> $next_step ]);

                if( $data['provider_agreement'] ){
                    $guardianformId = 11;
                    $agreement_link = route("admin.forms.create", [$guardianformId, $participant->user_id, $isParticipantTrue=1]);
                    return [ 'status'=>true, 'type'=>'redirect', 'redirect_url'=>$agreement_link ];
                }else{
                    // If Agreement Skipped go to Next Step
                    return [ 'status'=>true, 'type'=>'popup', 'next_step'=>$next_step, 'operationFormFill'=>$operationFormFill ];
                }
                    
            break;

            case 3:

                $data = $request->validate([
                                            'user_id' => 'required',
                                            'step' => 'required'
                                        ]);
                                        
                $participant = new Participant;

                //Fetch User data
                $participant = $participant->getParticipant( $data['user_id'] );
                
                
                if( !$participant ){
                    return [ 'status'=>false, 'message'=>'Invalid Submission! please try again later.' ];
                }

                $next_step = 4;
                //Update the Participant with given values
                $participant->where('participants_details.user_id', $participant->user_id)->update([ 'onboarding_step'=> $next_step ]);

                return [ 'status'=>true, 'type'=>'popup', 'next_step'=>$next_step ];

            break;
            case 4:

                $data = $request->validate([
                                            'start_booking' => 'required',
                                            'user_id' => 'required',
                                            'step' => 'required'
                                        ]);
                $participant = new Participant;

                //Fetch User data
                $participant = $participant->getParticipant( $data['user_id'] );
                
                
                if( !$participant ){
                    return [ 'status'=>false, 'message'=>'Invalid Submission! please try again later.' ];
                }

                
                $next_step = 9;
                
                if($participant->agreement_signed){
                    $onboarding_complete = 1;
                    //Update the Participant with given values
                    $participant->where('participants_details.user_id', $participant->user_id)->update([ 'onboarding_step'=> $next_step, 'is_onboarding_complete'=>$onboarding_complete ]);
                }else{
                    $onboarding_complete = 0;
                    $participant->where('participants_details.user_id', $participant->user_id)->update([ 'onboarding_step'=> 2, 'is_onboarding_complete'=>$onboarding_complete ]);
                }

                
                

                //Update the Participant with given values
                

                if( $data['start_booking'] ){
                    // $_link = route("admin.bookings.create");
                    $_link = route("admin.participants.availability",[$participant->user_id]);
                    return [ 'status'=>true, 'type'=>'redirect', 'redirect_url'=>$_link ];
                }else if($participant->using_guardian){
                    return [ 'status'=>true, 'type'=>'popup', 'next_step'=>$next_step ];
                }else{
                    return [ 'status'=>true, 'type'=>'finish' ];
                }

            break;


            // case 5:

            //     $data = $request->validate([
            //                                 'guardian_email' => 'required',
            //                                 'guardian_password' => 'required|min:6|confirmed',
            //                                 'user_id' => 'required',
            //                                 'step' => 'required'
            //                             ]);
            //     $participant = new Participant;

            //     //Fetch User data
            //     $participant = $participant->getParticipant( $data['user_id'] );
                
                
            //     if( !$participant ){
            //         return [ 'error'=>true, 'msg'=>'Invalid Submission! please try again later.' ];
            //     }

            //     $guardian = $participant->addParticipantGuardian( $data['user_id'], $data['guardian_email'], $data['guardian_password'] );

            //     $next_step = 9; // to finish this
            //     $onboarding_complete = 1;

            //     //Update the Participant with given values
            //     $participant->where('participants_details.user_id', $participant->user_id)->update([ 'onboarding_step'=> $next_step, 'is_onboarding_complete'=>$onboarding_complete ]);

            //     return [ 'status'=>true, 'type'=>'finish' ];


            // break;

            default:
                return [ 'status'=>false, 'message'=>trans('errors.internal_error'), 'step'=>intval($step) ];
            break;
        }
        
    }


    public function onboarding_validate( Request $request ){

        $data = $request->validate([
            'user_id' => 'required'
        ]);
        
        $participant = new Participant;

        //Fetch User data
        $participant = $participant->getParticipant( $data['user_id'] );

        
        if( !$participant ){
            return [ 'status'=>false, 'message'=>'Invalid Submission! please try again later.' ];
        }

        // dd($participant->onboarding_step);
        
        if( $participant->onboarding_step > 1){
            $submitted = \App\OperationalForms::where('user_id', $participant['user_id'])
                                            ->pluck('template_id');

            //check if careplan,riskassessment and clientconsent forms submitted
            if( $submitted->contains('2') && $submitted->contains('10') && $submitted->contains('3') ){
                $participant->onboarding_step = 4;
            } 

            //check if NDIS agreement submitted and signed by participant
            if( ! $submitted->contains('11') || ($submitted->contains('11') && !$participant->agreement_signed) ){
                $participant->onboarding_step = 2;
            }else{
                $participant->onboarding_step = 3;
            }

        }
        

        //Check if Agreement is Signed
        if($participant){
            
            return [ 'status'=>true, 'type'=>'popup', 'next_step'=>$participant->onboarding_step];
        }


        return [ 'status'=>false, 'message'=>'asdasda', 'participant'=>$participant ];
    }

}