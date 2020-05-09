<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupportWorkerRequest;
use App\Http\Requests\UpdateSupportWorkerRequest;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\StoreNotesRequest;
use App\RegistrationGroup;
use App\SupportWorker;
use App\User;
use App\UsersToProviders;
use App\Documents;
use App\Notes;
use App\Bookings;
use App\ProviderRegGroups;
use App\OperationalForms;
use Symfony\Component\HttpFoundation\Request;

use Illuminate\Support\Facades\DB;
use App\Notifications\UserActivation;

use Illuminate\Support\Facades\Gate;

class SupportWorkerController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(\Gate::allows('support_worker_access'), 403);
        $query='';
        if( isset( $request->s ) ){
            $query = $request->query('s');
            $supportWorkers = SupportWorker::searchSupportWorkers( trim($request->s) );
            $size = sizeof($supportWorkers);
            $result = 'result';
            if( $size > 1) $result = 'results';
            $msg = "Found <b>'" .$size ."'</b> ". $result." for your query of <b>'" .$request->s ."'</b>";
            $supportWorkers->search = array( 'message'=>$msg);
        }
        else
            $supportWorkers = SupportWorker::providerSupportWorkers();
        
        // pr($supportWorkers, 1);
        return view('admin.supportWorkers.index', compact('supportWorkers','query'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('support_worker_create'), 403);
        $provider = \Auth::user();
        
        $registration_groups = \App\RegistrationGroup::getInhouseByProvider($provider->id)->pluck('title','id');

        //we will check in onboarding if provider had a payment method
        if( ! Gate::allows('onboarding-complete', (\App\Provider::where('user_id', '=', \Auth::user()->id )->firstOrFail()->is_onboarding_complete))){
            return redirect()->route('admin.support-workers.index')->withErrors( trans('msg.provider.onboarding_pending',['link'=>route('admin.users.profile')]) );
        }
        
        //dd($registration_groups);
        return view('admin.supportWorkers.create', compact('registration_groups'));
    }

    public function store(StoreSupportWorkerRequest $request)
    {
        abort_unless(\Gate::allows('support_worker_create'), 403);
        $provider = \Auth::user();
        
        // pr($provider, 1);

        // if( $provider->hasPaymentMethod() ){
        //     return redirect()->route('admin.subscription.subscribe');
        // }

        //Set Default Fields for DB to save
        $request->request->add([ 'password'=>'empty' ]);
        

        //check if subscription exists or create one and charge provider
        // try {
        //     if ( $provider->subscribed( config('ndis.stripe_product') ) ) {
                
        //         //this is throwing error we might need to create function in stripetrait 
        //         $provider->subscription( config('ndis.stripe_product') )->incrementQuantity();
        //     }
        //     else{
        //         $provider->newSubscription( config('ndis.stripe_product'), config('ndis.stripe_plan') )->create();
        //     }
        // } catch (Exception $e) {
        //     return back()->withError($e->message());
        // }


        $user = User::create($request->all());
        
        $user->roles()->sync([4]);
        
        $supportWorker = SupportWorker::create([
            'user_id' => $user->id,
            'address' => $request->input('address'),
            'lat' => $request->input('lat'),
            'lng' => $request->input('lng'),
            'is_onboarding_complete' => 0,
            'onboarding_step' => 1
        ]);

        //Update Reg Groups
        $supportWorker->updateRegGroups($provider->id, $request->input('registration_groups_id', []) );

        $supportWorker = UsersToProviders::create([
            'user_id' => $user->id,
            'provider_id' => $provider->id
        ]);

        //Send Notification to the SupportWorker
        $user->notify(new \App\Notifications\UserActivation($user));
        
        return redirect()->route('admin.support-workers.edit', $user->id)->with('success', trans('msg.support_worker.success') );

    }

    public function edit( $swID )
    {
        abort_unless(\Gate::allows('support_worker_edit'), 403);       

        //check if admin (redirect to show view)
        if( checkUserRole('1') )return redirect()->route('admin.support-workers.show', [$swID]);

        $provider = \Auth::user();

        $registration_groups = \App\RegistrationGroup::getInhouseByProvider($provider->id)->pluck('title','id');

        $supportWorker = SupportWorker::with('reg_grps')->where('support_workers_details.user_id', $swID)->first();

        $activeTabInfo = $this->getActiveTab();

        return view( 'admin.supportWorkers.edit', compact('supportWorker', 'registration_groups', 'activeTabInfo') );
    }

    public function update(UpdateSupportWorkerRequest $request, $swID)
    {
        abort_unless(\Gate::allows('support_worker_edit'), 403);

        $supportWorker = SupportWorker::where('support_workers_details.user_id', $swID)->first();
        $provider = \Auth::user();
        // update support_workers_details table
        $supportWorker->update([
                                'address'=>$request->address, 
                                'lat'=>$request->lat , 
                                'lng'=>$request->lng
                        ]);

        //Update User as well
        $user = User::find( $request->input('user_id') );

        $user->update([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'email'=>$request->email,  
            'mobile'=>$request->mobile,  
            // 'avatar'=>$request->avatar,
            // 'provider_id'=>$request->input('provider_id'),
        ]);

        //Update Reg Groups
        $supportWorker->updateRegGroups( $provider->id, $request->input('registration_groups_id', []) );

        return redirect()->route('admin.support-workers.edit', $user->id)->with('success', 'Support Worker Profile updated.');
        // return redirect()->route('admin.support-workers.index');
    }

    public function show( $swID)
    {
        abort_unless(\Gate::allows('support_worker_show'), 403);

        $supportWorker = SupportWorker::with('reg_grps')->where('support_workers_details.user_id', $swID)->first();
        // dd($supportWorker->reg_grps);
        return view('admin.supportWorkers.show', compact('supportWorker'));
    }

    public function destroy( $swID)
    {
        abort_unless(\Gate::allows('support_worker_delete'), 403);

        // $supportWorker = SupportWorker::where('support_workers_details.user_id', $swID)->first();

        // $supportWorker->user()->delete();

        // $supportWorker->delete();

        // $supportWorker = SupportWorker::providerSupportWorkers();
        // return back();
        // return redirect()->route("admin.support-workers.index")->with('message',trans('msg.support_worker.message') );

        // return back();

       
        $deleted = false;
        $supportWorker = SupportWorker::find($swID);
        //  dd($supportWorker);
        if($supportWorker)
            $deleted = $supportWorker->delete();

        $user = User::find($supportWorker->user_id);
        if($user)
            $deleted = $user->delete();

        if ($deleted) {
            return redirect()->route("admin.support-workers.index")->with('message',trans('msg.support_worker.message') );
        } else {
            redirect()->route("admin.support-workers.index")->with('message:error', 'Unable to delete Record');
        }
    }


    public function bookings( $swID, Request $request )
    {
        abort_unless(\Gate::allows('support_worker_edit'), 403);
        
        $supportWorker = new SupportWorker;
        //Fetch User data
        $supportWorker = $supportWorker->getSupportWorker($swID);

        // pr($supportWorker->bookings, 1);

        $linked_participants = $supportWorker->getLinkedParticipantsAndBookings($swID);

       
        global $parti;
        if( $linked_participants->isNotEmpty() ){        
            $linked_participants->map(function ($item, $key) {
                global $parti;
                $parti[$item['participant_id']] = $item['participant_fname'] ." ". $item['participant_lname'] ." (".$item['participant_email'].")";
            });
            $supportWorker->participants = array_unique($parti);
        }
        $parti = null;

        // pr($linked_participants,1);
        // pr($supportWorker);
        // pr($request->all());

        if( !empty( $request->input('member') ) || !empty( $request->input('start_date') ) || !empty( $request->input('end_date') ) ){
            
            $v = $request->validate([
                'start_date' => 'bail|required| date',
                'end_date' => 'bail|required| date',
                'member' => 'bail|required| integer| not_in:0',
            ]);
            $supportWorker->linked_participants =  $supportWorker->getSearchedBookings($swID,$request);
           
        }else{

            $supportWorker->linked_participants = $linked_participants;

        }

        
        abort_unless($supportWorker, 404, "Invalid Support Worker!");
        
        $activeTabInfo = $this->getActiveTab();
        return view( 'admin.supportWorkers.edit', compact('supportWorker', 'activeTabInfo') );
    }

   
    //------------------------------------------------------------------------------------------
    // Notes Section

    public function notes( $swID )
    {
        // pr($swID,1);
        
        abort_unless(\Gate::allows('support_worker_edit'), 403);
        
        $supportWorker = new SupportWorker;
        
        //Fetch User data
        $supportWorker = $supportWorker->getSupportWorker($swID);

        abort_unless($supportWorker, 404, "Invalid Support Worker!");

        $supportWorker->notes = Notes::getUserNotes($swID);
        
        $activeTabInfo = $this->getActiveTab();
        return view( 'admin.supportWorkers.edit', compact('supportWorker', 'activeTabInfo') );
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notes_save( StoreNotesRequest $request, $swID )
    {

        // pr($swID,1);
        
        abort_unless(\Gate::allows('support_worker_edit'), 403);
        
        $supportWorker = new SupportWorker;
        
        //Fetch User data
        $supportWorker = $supportWorker->getSupportWorker($swID);

        abort_unless($supportWorker, 404, "Invalid Support Worker!");

        $user = \Auth::user();

        $note = new Notes();
        // pr($note,1);
        $note->title = $request->input('title');
        $note->description = $request->input('description');
        $note->type = 'support_worker';
        $note->relation_id = $request->input('user_id');
        $note->provider_id = $user->id;
        $note->created_by = $user->id;
        $note->save();

        return redirect()->route("admin.support-workers.notes", [$supportWorker->user_id])->with('message',trans('msg.support_worker_note.message')  );
    }




  //------------------------------------------------------------------------------------------
    // Wizard Section

    // public function documents2( $participantId )
    // {
    //     abort_unless(\Gate::allows('participant_edit'), 403);
        
    //     $participant = new Participant;
        
    //     //Fetch User data
    //     $participant = $participant->getParticipant($participantId);

    //     abort_unless($participant, 404, "Invalid Participant!");

    //     $participant->documents = Documents::getUserDocuments($participantId);
        
    //     $activeTabInfo = $this->getActiveTab();
    //     return view( 'admin.participants.edit', compact('participant', 'activeTabInfo') );
    // }

    //------------------------------------------------------------------------------------------
    // Documents Section

    public function documents( $swID )
    {
        abort_unless(\Gate::allows('support_worker_edit'), 403);
        
        $supportWorker = new SupportWorker;
        
        //Fetch User data
        $supportWorker = $supportWorker->getSupportWorker($swID);

        abort_unless($supportWorker, 404, "Invalid Support Worker!");

        $supportWorker->documents = Documents::getUserDocuments($swID);

        $opforms = OperationalForms::supportWorker( $swID )->get();
        
        $activeTabInfo = $this->getActiveTab();

        return view( 'admin.supportWorkers.edit', compact('supportWorker', 'opforms', 'activeTabInfo') );
    }


    public function document_new( $swID )
    {
        abort_unless(\Gate::allows('support_worker_edit'), 403);
        
        $supportWorker = new SupportWorker;
        
        //Fetch User data
        $supportWorker = $supportWorker->getSupportWorker($swID);

        abort_unless($supportWorker, 404, "Invalid Support Worker!");

        $activeTabInfo = $this->getActiveTab();
        
        return view( 'admin.supportWorkers.edit', compact('supportWorker', 'activeTabInfo') );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function document_save( StoreDocumentRequest $request, $swID )
    {

        abort_unless(\Gate::allows('support_worker_edit'), 403);

        //Validation is added to REQUEST
        // $this->validate($request, [
        //         'document' => 'mimes:jpeg,png,bmp,tiff |max:4096',
        //     ],
        //     $messages = [
        //         'required' => 'The :attribute field is required.',
        //         'mimes' => 'Only jpeg, png, bmp,tiff are allowed.'
        //     ]
        // );
        
        $supportWorker = new SupportWorker;
        
        //Fetch User data
        $supportWorker = $supportWorker->getSupportWorker($swID);

        abort_unless($supportWorker, 404, "Invalid Support Worker!");

        $image = $request->file('document');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('uploads'),$imageName);

        $user = \Auth::user();
        
        $documents = new Documents();
        $documents->local_path = $imageName;
        $documents->title = $request->input('title');
        $documents->user_id = $request->input('user_id');
        $documents->provider_id = $user->id;
        $documents->save();

        return redirect()->route("admin.support-workers.documents", [$supportWorker->user_id])->withSuccess('Document added successfully!');
    }

    public function paymentHistory( $swID, SupportWorker $supportWorker)
    {
        abort_unless(\Gate::allows('support_worker_edit'), 403);
        
        //Fetch User data
        $supportWorker = $supportWorker->getSupportWorker($swID);

        abort_unless($supportWorker, 404, "Invalid Support Worker!");

        $supportWorker->load('bookingOrder');

        // $supportWorker->payment_history = $supportWorker->getPaymentHistory($swID);

        // pr($supportWorker->toArray());
        // pr($supportWorker->load('bookings')->toArray(), 1);
        
        // pr($supportWorker->toArray(),1);
        
        $activeTabInfo = $this->getActiveTab();

        return view( 'admin.supportWorkers.edit', compact('supportWorker', 'activeTabInfo') );
    }

    public function linkedParticipants( $swID )
    {
        abort_unless(\Gate::allows('support_worker_edit'), 403);
        
        $supportWorker = new SupportWorker;
        
        //Fetch User data
        $supportWorker = $supportWorker->getSupportWorker($swID);
        

        abort_unless($supportWorker, 404, "Invalid Support Worker!");

        

        $supportWorker->linked_participants = $supportWorker->getLinkedParticipantsAndBookings($swID)->unique('participant_id');
        
        // dd($supportWorker->linked_participants);s
        // $supportWorker->bookings = $supportWorker->getSWBookings($swID);

        // pr($supportWorker, 1);
        
        $activeTabInfo = $this->getActiveTab();
        return view( 'admin.supportWorkers.edit', compact('supportWorker', 'activeTabInfo') );
    }




    //------------------------------------------------------------------------------------------
    // Helper Functions
    //------------------------------------------------------------------------------------------
    private function getActiveTab(){
        
        $activeTabInfo = [ 'tab'=>'edit', 'file'=>"admin.supportWorkers.edit_index" ];

        if ( request()->is('admin/support-workers/*/documents') ):
            
            $activeTabInfo = [ 'tab'=>'documents', 'file'=>"admin.supportWorkers.edit_documents" ]; 
        
        elseif ( request()->is('admin/support-workers/*/documents/new') ):
            
            $activeTabInfo = [ 'tab'=>'documents', 'file'=>"admin.supportWorkers.create_documents", "title" => trans('documents.new_document') ];

        elseif ( request()->is('admin/participants/*/availability') ):
            
            $activeTabInfo = [ 'tab'=>'availability', 'file'=>"admin.supportWorkers.edit_availability" ];

        elseif ( request()->is('admin/support-workers/*/bookings') ):
            
            $activeTabInfo = [ 'tab'=>'bookings', 'file'=>"admin.supportWorkers.edit_bookings" ];

        elseif ( request()->is('admin/support-workers/*/notes') ):
            
            $activeTabInfo = [ 'tab'=>'notes', 'file'=>"admin.supportWorkers.edit_notes" ];

        elseif ( request()->is('admin/support-workers/*/payment-history') ):
            
            $activeTabInfo = [ 'tab'=>'payment-history', 'file'=>"admin.supportWorkers.edit_payment_history" ];

        elseif ( request()->is('admin/support-workers/*/linked-participants') ):
            
            $activeTabInfo = [ 'tab'=>'linked-participants', 'file'=>"admin.supportWorkers.edit_linked_participants" ];

        endif;

        return $activeTabInfo;
    }



    public function onboarding_steps( Request $request )
    {
        //dd($request);
        $step = $request->input('step');
        
        switch( intval($step) ){

            case 1:
                
                $data = $request->validate([
                                                'provider_agreement' => 'required',
                                                'user_id' => 'required',
                                                'step' => 'required'
                                            ]);

                $supportWorker = new SupportWorker;

                //Fetch User data
                $supportWorker = $supportWorker->getSupportWorker( $data['user_id'] );
                
                
                if( !$supportWorker ){
                    return [ 'status'=>false, 'message'=>'Invalid Submission! please try again later.' ];
                }

                $next_step = 2;
                    
                    //Update the supportWorker with given values
                $supportWorker->where('support_workers_details.user_id', $supportWorker->user_id)->update([ 'onboarding_step'=> $next_step ]);

                if( $data['provider_agreement'] ){
                    $form_id = 13;
                    $agreement_link = route("admin.forms.create", [$form_id, $supportWorker->user_id, $isParticipantTrue=2]);
                    return [ 'status'=>true, 'type'=>'redirect', 'redirect_url'=>$agreement_link ];
                }else{
                    // If Agreement Skipped go to Next Step
                    return [ 'status'=>true, 'type'=>'popup', 'next_step'=>$next_step ];
                }
                    
            break;


            case 2:
                
                $data = $request->validate([
                                            'user_id' => 'required',
                                            'step' => 'required'
                                        ]);

                $supportWorker = new SupportWorker;

                //Fetch User data
                $supportWorker = $supportWorker->getSupportWorker( $data['user_id'] );
                
                
                if( !$supportWorker ){
                    return [ 'status'=>false, 'message'=>'Invalid Submission! please try again later.' ];
                }

                if($supportWorker->agreement_signed){
                    $next_step = 5;

                    //Update the supportWorker with given values
                    $supportWorker->where('support_workers_details.user_id', $supportWorker->user_id)->update([ 'is_onboarding_complete'=>1, 'onboarding_step'=> $next_step ]);
                }else{
                    $supportWorker->where('support_workers_details.user_id', $supportWorker->user_id)->update([ 'is_onboarding_complete'=>0, 'onboarding_step'=> 1 ]);
                    $next_step = 5;
                }

                
                return [ 'status'=>true, 'type'=>'popup', 'next_step'=>$next_step ];
                                    
            break;


            default:
                return [ 'status'=>false, 'message'=>trans('errors.internal_error'), 'step'=>intval($step) ];
            break;
        }
        
    }


    public function onboarding_validate( Request $request ){

        $data = $request->validate([
            'user_id' => 'required'
        ]);
        
        $supportWorker = new SupportWorker;

        //Fetch User data
        $supportWorker = $supportWorker->getSupportWorker( $data['user_id'] );

        if( !$supportWorker ){
            return [ 'status'=>false, 'message'=>'Invalid Submission! please try again later.' ];
        }

        //Quick fix for Onboarding Step
        if(!$supportWorker->agreement_signed){
            $supportWorker->is_onboarding_complete = 0;
            $supportWorker->onboarding_step = 1;
        }
        
        return [ 'status'=>true, 'type'=>'popup', 'next_step'=>$supportWorker->onboarding_step ];
    }    

}
