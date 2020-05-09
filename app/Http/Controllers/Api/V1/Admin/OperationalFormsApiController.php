<?php

namespace App\Http\Controllers\Api\V1\Admin;


use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\SignatureTrait;
use App\Http\Controllers\Traits\OpformTrait;
use App\Http\Controllers\Traits\OpFormValidationTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\OperationalForms;
use App\OpformTemplates;
use App\User;
use App\OpformMeta;
use App\Role;
use App\RegistrationGroup;
use App\ParticipantRegGroups;
use App\Participant;
use Illuminate\Support\Facades\DB;
use App\ProviderRegGroups;
use OpformsTemplates;
use App\UsersToProviders;
use Exception;

use App\Documents;
use PDF;

class OperationalFormsApiController extends Controller
{
    use SignatureTrait, OpformTrait, OpFormValidationTrait;

    public $workerOnlyTemplate = [];
    public $participantOnlyTemplates = [];
    public $externalOnlyTemplate = [];

    public function __construct()
    {
        parent::__construct();
       
        $this->workerOnlyTemplate = [ 8, 13 ];
        $this->participantOnlyTemplates = [1, 2, 3,4,5,6,7, 9, 10,11 ];
        $this->externalOnlyTemplate = [13];
     
    }

    /***************************************************************************************************/
    /******************************** Start Get Form route functions ***********************************/

    /**
     * Get PDF of form
     */
    public function view(Request $request, $id, $participantController=null)
    {
        
        $user = \Auth::user();
        
        $form =  OperationalForms::where('user_id',$user->id)
                                ->where('template_id',$id)
                                ->first();
        // dd($form,1);
        if(!$form)
            return response()->json( array('status' => false, 'message'=>'No form found.' ) );
        
        $meta = $form->getMeta();

        // pr($meta,1);

        $formAction[0] = 'admin.forms.update';
        $formAction[1] = $form->id;
        $readOnly = 1;

        $provider = User::find($form->provider_id);
        $registeration_group = RegistrationGroup::getByProvider($provider->id)->pluck('title','id');
        
        // $user = \App\User::findOrFail( $form->user_id );
        
        // For Participant Forms
        if( $user->roles()->get()->contains( config('ndis.participant_role_id') ) && in_array($form->template_id, $this->participantOnlyTemplates) ) {
            
            $participant = \App\Participant::where('participants_details.user_id', $form->user_id)->first();
            
            $particiPant_reg_group = RegistrationGroup::getByParticipant($provider->id, $participant->user_id)->get();
            
            $child_items_group = RegistrationGroup::getRegItemsForSelection( $particiPant_reg_group->pluck('id')->toArray() )->get();

            $regDataTable = $this->getRegGroupTable($form->provider_id, $form->user_id, $particiPant_reg_group, $child_items_group);

            $selected_items_group = RegistrationGroup::getRegItemsForSelectionEdit($provider->id, $participant->user_id)->get();
            
            try{
                PDF::setOptions(['dpi' => 100, 'defaultFont' => 'sans-serif']);
                
                $pdf = PDF::loadView('admin.operationalForms.view', compact( 'participantController', 'form', 'provider', 'registeration_group', 'particiPant_reg_group',  'meta','formAction', 'participant', 'readOnly', 'child_items_group', 'selected_items_group', 'regDataTable'));
                
                $file = $pdf->save(storage_path().'/'.$user->id.'_'.$id.'_form.pdf');

            //    dd('remove before push');
                

                if( $file ){

                    $file = new \Illuminate\Http\UploadedFile(
                                storage_path().'/'.$user->id.'_'.$id.'_form.pdf',
                                $user->id.'_'.$id.'_form.pdf'
                            );
                    $toSw = Documents::saveFileGetInfo( $file ,  $user->id);
                            
                    unlink(storage_path().'/'.$user->id.'_'.$id.'_form.pdf');

                }
                
                return response()->json( array('status' => true, 'pdf'=>$toSw->fileURL ) );
            }
            catch(Exception $exception){
                return reportAndRespond($exception, 400);
            }

        }
        
        // For Support Worker Forms
        if(  $user->roles()->get()->contains( config('ndis.support_worker_role_id') ) && in_array($form->template_id, $this->workerOnlyTemplate) ) {
            // dd($user->roles()->get());
            $participant = \App\SupportWorker::where('support_workers_details.user_id', $form->user_id)->first();
            
            $participant->load('reg_grps');
            
            $registration_groups = \App\RegistrationGroup::getInhouseByProvider($provider->id)->pluck('title','id');
            
            $roleName = trans('opforms.fields.support_worker');
            $agreementName = 'support';

            try{ 

                PDF::setOptions(['dpi' => 100, 'defaultFont' => 'sans-serif']);
                
                $pdf = PDF::loadView('admin.operationalForms.view', compact( 'participantController', 'form', 'provider', 'registration_groups', 'meta','formAction', 'participant', 'readOnly', 'agreementName', 'roleName'));
                
                // dd(public_path());
                // $pdf = PDF::loadView('test');
                set_time_limit(30000);
                //dd($pdf);
                $file = $pdf->save(storage_path().'/pdf/'.$user->id.'_'.$id.'_form.pdf');
                dd($file);

                if( $file ){

                    $file = new \Illuminate\Http\UploadedFile(
                                storage_path().'/pdf/'.$user->id.'_'.$id.'_form.pdf',
                                $user->id.'_'.$id.'_form.pdf'
                            );
                    // dd($file);
                    
                    $toSw = Documents::saveFileGetInfo( $file ,  $user->id);

                }
                
                // dd($toSw);
                // dd($file);

                return response()->json( array('status' => true, 'pdf'=>$toSw->fileURL ) );
            }
            catch(Exception $exception){
                return reportAndRespond($exception, 400);
            }

            return view('admin.operationalForms.view', compact( 'participantController', 'form', 'provider', 'registration_groups', 'meta','formAction', 'participant', 'readOnly', 'agreementName', 'roleName'));
        }

        // // For External Support Worker Forms
        // if(  $user->roles()->get()->contains( config('ndis.external_service_role_id') ) && in_array($form->template_id, $this->externalOnlyTemplate) ) {
            
        //     $participant = \App\ServiceProvider::where('service_provider_details.user_id', $form->user_id)->first();
            
        //     $participant->load('reg_grps');

        //     $registration_groups = \App\RegistrationGroup::getExternalByProvider($provider->id)->pluck('title','id');
            
        //     $roleName = trans('opforms.fields.ext_service_provider');
        //     $agreementName = 'service';

        //     return view('admin.operationalForms.view', compact( 'participantController', 'form', 'provider', 'registration_groups', 'meta','formAction', 'participant', 'readOnly', 'agreementName', 'roleName'));
        // }

        // //If Incident Report
        // if( $form->template_id == 8 ){
            
        // }
       
    }

    /**
     * Get Form 1
     * 
    */
    public function getTemplateOne( Request $request ){
        
        try{

            $user = User::find(Auth::id());

            $form =  OperationalForms::where('user_id',$user->id)->where('template_id',1)->first();

            if(!$form)
                return response()->json(['status'=>false,'message'=>'Sorry, Form Not Found!'], 400);
        
            $meta = $form->getMeta();
            
            return response()->json( array('status' => true, 'form_data'=>$meta ) );
        }
        catch(Exception $exception){
            return reportAndRespond($exception, 400);
        }   
        

    }

    /**
     * Get Form 2
     * 
    */
    public function getTemplateTwo( Request $request ){

        try{

            $user = User::find(Auth::id());

            $form =  OperationalForms::where('user_id',$user->id)->where('template_id',2)->first();

            if(!$form)
                return response()->json(['status'=>false,'message'=>'Sorry, Form Not Found!'], 400);
        
            $meta = $form->getMeta();
            
            return response()->json( array('status' => true, 'form_data'=>$meta ) );
        }
        catch(Exception $exception){
            return reportAndRespond($exception, 400);
        }

    }

    /**
     * Get Form 3
     * 
    */
    public function getTemplateThree( Request $request ){

        try{

            $user = User::find(Auth::id());

            $form =  OperationalForms::where('user_id',$user->id)->where('template_id',3)->first();

            if(!$form)
                return response()->json(['status'=>false,'message'=>'Sorry, Form Not Found!'], 400);
        
            $meta = $form->getMeta();
            
            return response()->json( array('status' => true, 'form_data'=>$meta ) );
        }
        catch(Exception $exception){
            return reportAndRespond($exception, 400);
        }

    }

    /**
     * Get Form 4
     * 
    */
    public function getTemplateFour( Request $request ){

        try{

            $user = User::find(Auth::id());

            $form =  OperationalForms::where('user_id',$user->id)->where('template_id',4)->first();

            if(!$form)
                return response()->json(['status'=>false,'message'=>'Sorry, Form Not Found!'], 400);
        
            $meta = $form->getMeta();
            
            return response()->json( array('status' => true, 'form_data'=>$meta ) );
        }
        catch(Exception $exception){
            return reportAndRespond($exception, 400);
        }

    }

    /**
     * Get Form 5
     * 
    */
    public function getTemplateFive( Request $request ){

        try{

            $user = User::find(Auth::id());

            $form =  OperationalForms::where('user_id',$user->id)->where('template_id',5)->first();

            if(!$form)
                return response()->json(['status'=>false,'message'=>'Sorry, Form Not Found!'], 400);
        
            $meta = $form->getMeta();
            
            return response()->json( array('status' => true, 'form_data'=>$meta ) );
        }
        catch(Exception $exception){
            return reportAndRespond($exception, 400);
        }

    }
    
    /**
     * Get Form 6
     * 
    */
    public function getTemplateSix( Request $request ){

        try{

            $user = User::find(Auth::id());

            $form =  OperationalForms::where('user_id',$user->id)->where('template_id',6)->first();

            if(!$form)
                return response()->json(['status'=>false,'message'=>'Sorry, Form Not Found!'], 400);
        
            $meta = $form->getMeta();
            
            return response()->json( array('status' => true, 'form_data'=>$meta ) );
        }
        catch(Exception $exception){
            return reportAndRespond($exception, 400);
        }

    }

    /**
     * Get Form 7
     * 
    */
    public function getTemplateSeven( Request $request ){

        try{

            $user = User::find(Auth::id());

            $form =  OperationalForms::where('user_id',$user->id)->where('template_id',7)->first();

            if(!$form)
                return response()->json(['status'=>false,'message'=>'Sorry, Form Not Found!'], 400);
        
            $meta = $form->getMeta();
            
            return response()->json( array('status' => true, 'form_data'=>$meta ) );
        }
        catch(Exception $exception){
            return reportAndRespond($exception, 400);
        }

    }

    /**
     * Get Form 8
     * 
    */
    public function getTemplateEight( Request $request ){

        try{

            $user = User::find(Auth::id());

            $form =  OperationalForms::where('user_id',$user->id)->where('template_id',8)->first();

            if(!$form)
                return response()->json(['status'=>false,'message'=>'Sorry, Form Not Found!'], 400);
        
            $meta = $form->getMeta();
            
            return response()->json( array('status' => true, 'form_data'=>$meta ) );
        }
        catch(Exception $exception){
            return reportAndRespond($exception, 400);
        }

    }

    /**
     * Get Form 9
     * 
    */
    public function getTemplateNine( Request $request ){

        try{

            $user = User::find(Auth::id());

            $form =  OperationalForms::where('user_id',$user->id)->where('template_id',9)->first();

            if(!$form)
                return response()->json(['status'=>false,'message'=>'Sorry, Form Not Found!'], 400);
        
            $meta = $form->getMeta();
            
            return response()->json( array('status' => true, 'form_data'=>$meta ) );
        }
        catch(Exception $exception){
            return reportAndRespond($exception, 400);
        }

    }

    /**
     * Get Form 10
     * 
    */
    public function getTemplateTen( Request $request ){

        try{

            $user = User::find(Auth::id());

            $form =  OperationalForms::where('user_id',$user->id)->where('template_id',10)->first();

            if(!$form)
                return response()->json(['status'=>false,'message'=>'Sorry, Form Not Found!'], 400);
        
            $meta = $form->getMeta();
            
            return response()->json( array('status' => true, 'form_data'=>$meta ) );
        }
        catch(Exception $exception){
            return reportAndRespond($exception, 400);
        }

    }

    /**
     * Get Form 11
     * 
    */
    public function getTemplateEleven( Request $request ){

        try{

            $user = User::find(Auth::id());

            $form =  OperationalForms::where('user_id',$user->id)->where('template_id',11)->first();

            if(!$form)
                return response()->json(['status'=>false,'message'=>'Sorry, Form Not Found!'], 400);
        
            $meta = $form->getMeta();
            
            return response()->json( array('status' => true, 'form_data'=>$meta ) );
        }
        catch(Exception $exception){
            return reportAndRespond($exception, 400);
        }

    }

    /**
     * Get Form 12
     * 
    */
    public function getTemplateTwelve( Request $request ){

        try{

            $user = User::find(Auth::id());

            $form =  OperationalForms::where('user_id',$user->id)->where('template_id',12)->first();

            if(!$form)
                return response()->json(['status'=>false,'message'=>'Sorry, Form Not Found!'], 400);
        
            $meta = $form->getMeta();
            
            return response()->json( array('status' => true, 'form_data'=>$meta ) );
        }
        catch(Exception $exception){
            return reportAndRespond($exception, 400);
        }

    }

    /**
     * Get Form 13
     * 
    */
    public function getTemplateThirteen( Request $request ){

        try{

            $user = User::find(Auth::id());

            $form =  OperationalForms::where('user_id',$user->id)->where('template_id',13)->first();

            if(!$form)
                return response()->json(['status'=>false,'message'=>'Sorry, Form Not Found!'], 400);
        
            $meta = $form->getMeta();
            
            return response()->json( array('status' => true, 'form_data'=>$meta ) );
        }
        catch(Exception $exception){
            return reportAndRespond($exception, 400);
        }

    }

    /******************************** End Get Form route functions *************************************/
    /***************************************************************************************************/


 
    /***************************************************************************************************/
    /******************************** Start Update Form route functions ********************************/

    /**
     * Update Form 1
     * 
    */
    public function updateTemplateOne( Request $request ){

        $messages = [
            'participant_address'   => 'Participant address is required',
            'participant_lat'       => 'Invalid address!',
            'participant_lng'       => 'Invalid address!',
            'advocate_name'         => 'Advocate name is required',
            'advocate_address'      => 'Advocate address is required',
            'advocate_lat'          => 'Invalid address!',
            'advocate_lng'          => 'Invalid address!',
            'advocate_email'        => 'Advocate email is required'
        ];
        $data = Validator::make($request->all(),[           
            'participant_address'   => 'required',
            'participant_lat'       => 'required',
            'participant_lng'       => 'required',
            'advocate_name'         => 'required',
            'advocate_address'      => 'required',
            'advocate_lat'          => 'required',
            'advocate_lng'          => 'required',
            'advocate_email'        => 'required',
        ], $messages);
        
        //return error if any field is missing
        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;

        return response()->json( array('status' => true, 'form'=>$request->id ) );

    }

    /**
     * Update Form 2
     * 
    */
    public function updateTemplateTwo( Request $request ){

        return response()->json( array('status' => true, 'form'=>$request->id ) );

    }

    /**
     * Update Form 3
     * 
    */
    public function updateTemplateThree( Request $request ){

        return response()->json( array('status' => true, 'form'=>$request->id ) );

    }

    /**
     * Update Form 4
     * 
    */
    public function updateTemplateFour( Request $request ){

        return response()->json( array('status' => true, 'form'=>$request->id ) );

    }

    /**
     * Update Form 5
     * 
    */
    public function updateTemplateFive( Request $request ){

        return response()->json( array('status' => true, 'form'=>$request->id ) );

    }
    
    /**
     * Update Form 6
     * 
    */
    public function updateTemplateSix( Request $request ){

        return response()->json( array('status' => true, 'form'=>$request->id ) );

    }

    /**
     * Update Form 7
     * 
    */
    public function updateTemplateSeven( Request $request ){

        return response()->json( array('status' => true, 'form'=>$request->id ) );

    }

    /**
     * Update Form 8
     * 
    */
    public function updateTemplateEight( Request $request ){

        return response()->json( array('status' => true, 'form'=>$request->id ) );

    }

    /**
     * Update Form 9
     * 
    */
    public function updateTemplateNine( Request $request ){

        return response()->json( array('status' => true, 'form'=>$request->id ) );

    }

    /**
     * Update Form 10
     * 
    */
    public function updateTemplateTen( Request $request ){

        return response()->json( array('status' => true, 'form'=>$request->id ) );

    }

    /**
     * Update Update Form 11
     * 
    */
    public function updateTemplateEleven( Request $request ){

        return response()->json( array('status' => true, 'form'=>$request->id ) );

    }

    /**
     * Update Form 12
     * 
    */
    public function updateTemplateTwelve( Request $request ){

        return response()->json( array('status' => true, 'form'=>$request->id ) );

    }

    /**
     * Update Form 13
     * 
    */
    public function updateTemplateThirteen( Request $request ){

        return response()->json( array('status' => true, 'form'=>$request->id ) );

    }

    public function getRegGroupTable($provider_id, $participant_id, $parent_group, $child_group ){
        
        $parentGrp = $parent_group->map(function($item,$key){
            return $item->id;
        })->toArray();

        $childGrp = $child_group->map(function($item,$key){
            return $item->id;
        })->toArray();
        
        if($parentGrp && is_array($parentGrp) && !empty($parentGrp)) {

            $regGroups = new RegistrationGroup;

            $childGroups = $regGroups->getRegItemsForParents($parentGrp, $childGrp)->get();
            
            $participantGrps =  ParticipantRegGroups::where([ 'user_id'=>(int)$participant_id, 'provider_id'=>$provider_id ])->get();

            $participantItems = [];
            foreach($participantGrps as $participantGrp){
                $participantItems[$participantGrp->reg_item_id]['anual'] = $participantGrp->budget;
                $participantItems[$participantGrp->reg_item_id]['monthly'] = $participantGrp->monthly_budget;
                $participantItems[$participantGrp->reg_item_id]['frequency'] = $participantGrp->frequency;
            }
            
            $returnHTML = view('admin.operationalForms.pdf.11_reggroups', compact('childGroups', 'participantItems') )->render();
            
            return $returnHTML;
        }
        return false;
    }
    
    /********************************End Update Form route functions *************************************/
    /*****************************************************************************************************/


}
