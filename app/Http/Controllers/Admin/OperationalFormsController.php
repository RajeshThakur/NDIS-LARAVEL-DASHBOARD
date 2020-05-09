<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\SignatureTrait;
use App\Http\Controllers\Traits\OpformTrait;
use App\Http\Controllers\Traits\OpFormValidationTrait;
use Illuminate\Support\Facades\Validator;

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
use App\Http\Requests\UpdateOperationalFormsRequest;

class OperationalFormsController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        $provider = \Auth::user();

        $query = "";
        $participantOnlyTemplates = $this->participantOnlyTemplates;
        $workerOnlyTemplate = $this->workerOnlyTemplate;
        $externalOnlyTemplate = $this->externalOnlyTemplate;
        
        if($request->query('q'))
            $query = $request->query('q');
        
        
        // $opforms = OperationalForms::providerOperationalForms( $query );
        $opforms = OperationalForms::provider( $query )->get();

        // pr($opforms, 1);

        $opformTemplates = OpformTemplates::where('status', '1')->get()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');
        
        //there we take the users name and their role//
        //$users = User::with('rolesFilter')->get();
        $users2provider = UsersToProviders::where('provider_id', $provider->id)->get()->pluck('user_id');
        
        $users = User::whereIn('id',$users2provider)->get();
        
        $userName = array();
        $userRole = array();
        //in this loop we check the usertype and assign to array which user we requrire for operational form
        foreach($users as $user){
            
            if(!empty($user->rolesFilter[0])){
                $userName[$user->id] = $user->getName();
                $userRole[$user->id] = $user->rolesFilter[0]->title;
            }
                
        }
        
        $userName[0] = trans('global.pleaseSelect');
        
        return view('admin.operationalForms.index', compact('opforms', 'opformTemplates','userName', 'userRole', 'query', 'workerOnlyTemplate', 'participantOnlyTemplates', 'externalOnlyTemplate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(OperationalForms $OperationalForms, $templateId, $user_id, $participantController=null)
    {
        
        $formAction[0] = 'admin.forms.store';
        $formAction[1] = '';

        //there we check if participant id fill the advocate form for representative
        $form = $OperationalForms->where('user_id', $user_id)
            ->where('template_id' , $templateId)
            ->first();

        
        //if Existing Form then redirect to Edit mode
        if( $form ) {
            
            //if provider select the ndis aggrement then we check here said aggrement done with participant if provider select else then form must not open else continue
            return redirect()->route('admin.forms.edit', [$form->id, $participantController]);
        }

        $user = \App\User::findOrFail($user_id);
        
        $readOnly = 0;
        $meta = null;
        $provider = \Auth::user();
        $provider->load('provider');
        //dd($provider->provider->business_name);
        if( $user->roles()->get()->contains( config('ndis.participant_role_id') ) && in_array($templateId, $this->participantOnlyTemplates) ) {

            $participant = \App\Participant::where('participants_details.user_id', $user_id)->first();

            if(!$participant ) {
                // pr(1,1);
                return redirect()->back()->withErrors(['Participant Not Found!']);
            } elseif($participant && $templateId == 11) {
                
                $registeration_group = RegistrationGroup::getByProvider($provider->id)->pluck('title','id');
                $child_items_group = collect([]);
                    
                return view( 'admin.operationalForms.create', compact('meta', 'templateId','formAction','participant','provider','registeration_group','participantController','readOnly','child_items_group') );
            }

            return view('admin.operationalForms.create', compact( 'meta','templateId','formAction','participant','participantController','readOnly'));

        }

        if(  $user->roles()->get()->contains( config('ndis.support_worker_role_id') ) && in_array($templateId, $this->workerOnlyTemplate) ) {
            
            $participant = \App\SupportWorker::where('support_workers_details.user_id', $user_id)->first();

            $participant->load('reg_grps');
            
            $registration_groups = \App\RegistrationGroup::getInhouseByProvider($provider->id)->pluck('title','id');
            
            $agreementName = 'support';
            $roleName = trans('opforms.fields.support_worker');
            return view('admin.operationalForms.create', compact( 'meta','templateId','formAction','participant', 'provider', 'participantController', 'registration_groups', 'readOnly', 'roleName', 'agreementName'));

        }

        if(  $user->roles()->get()->contains( config('ndis.external_service_role_id') ) && in_array($templateId, $this->externalOnlyTemplate) ) {
            
            $participant = \App\ServiceProvider::where('service_provider_details.user_id', $user_id)->first();

            $participant->load('reg_grps');

            $registration_groups = \App\RegistrationGroup::getExternalByProvider($provider->id)->pluck('title','id');

            $agreementName = 'service';
            $roleName = trans('opforms.fields.ext_service_provider');
            return view('admin.operationalForms.create', compact( 'meta','templateId','formAction','participant', 'provider', 'participantController', 'registration_groups', 'readOnly', 'roleName', 'agreementName'));

        }
        
        return redirect()->back();

    }





    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        abort_unless(\Gate::allows('participant_create'), 403);
        
        // dd($request);
        $user_id = $request->input('user_id');
        $template_id = $request->input('template_id');
        $meta_fields = $request->input('meta',[]);
        $form_title = OpformTemplates::where('id',$template_id)->get()->pluck('title');
        
        $validator = $this->validateForm($request, $template_id);

        // pr($request->all(), 1);
        //dd($validator);

        // if(isset($validator)):
        //     if($validator->fails()):
        //         $messages = $validator->customMessages;
        //         return redirect()->back()->withErrors($messages);
        //     endif;
        // endif;
        

        $provider = \Auth::user();

        $opform = OperationalForms::where('user_id',$user_id)->where('template_id',$template_id)->first();  

        if(!$opform){

            $opform = OperationalForms::create([
                'title'=> $form_title->get('0'),
                'date'=>Carbon::now(),
                'user_id'=> $user_id,
                'template_id'=> $template_id,
                'provider_id'=> $provider->id
            ]);
        }
            

        $metaData = [];

        foreach($meta_fields as $key => $val){
            $metaData[] = [ 'opform_id' => $opform->id, 'meta_key' => $key, 'meta_value' => serialize($val) ];
        }

        // Save MetaData
        $opform->meta()->insert( $metaData );

        //Perform tasks based on template ID
        switch( intval($template_id) ){
            case 1:
            
                $this->maybeSaveParticipantData($request); 
                // Maybe Save Guardian Data
                $this->maybeSaveGuardian($request);
            break;
            case 2:
            break;
            case 3:
            break;
            case 4:
            break;
            case 5:
            break;
            case 6:
            break;
            case 7:
            break;
            case 8:
            break;
            case 9:
            break;
            case 10:
            break;
            case 11:
                // Maybe Save Participant Data
                $this->maybeSaveParticipantData($request);
                $this->saveParticipantRegGroups($request);
                $this->checkAgreementSigned($request);
            break;
            case 12:
            break;
            case 13:
                $this->saveSupportServiceRegGroups($request);
                $this->checkAgreementSigned($request);
            break;
        }

        //there we check if store method call from partifipant controller if yes then redirect to participant
        if ( $request->get('participant_controller', 0) ) {
            $route = route('admin.participants.edit', [ \App\Participant::where('participants_details.user_id', (int)$request->input('user_id') )->first()->id ]);
            return redirect($route);
        }

        //there we check if store method call from partifipant controller if yes then redirect to participant
        if ( $request->get('worker_controller', 0) == '2' ) {
            $route = route('admin.support-workers.edit', [(int)$request->input('user_id')]);
            return redirect($route);
        }

        if ( $request->get('worker_controller', 0) == '3' ) {            
            $route = route('admin.provider.edit', [(int)$request->input('user_id')]);

            return redirect($route);
        }
        
        return redirect('admin/forms');

    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(OperationalForms $OperationalForms, $id, $participantController=null)
    {
        
        $form =  OperationalForms::where('id',$id)->first();
        
        if(!$form)
            abort('Not Found', 403);
        
        $meta = $form->getMeta();

        // pr($meta);

        $formAction[0] = 'admin.forms.update';
        $formAction[1] = $form->id;
        $readOnly = 1;

        $provider = \Auth::user();
        $registeration_group = RegistrationGroup::getByProvider($provider->id)->pluck('title','id');
        
        $user = \App\User::findOrFail( $form->user_id );
        
        // For Participant Forms
        if( $user->roles()->get()->contains( config('ndis.participant_role_id') ) && in_array($form->template_id, $this->participantOnlyTemplates) ) {
            
            $participant = \App\Participant::where('participants_details.user_id', $form->user_id)->first();
            
            $particiPant_reg_group = RegistrationGroup::getByParticipant($provider->id, $participant->user_id)->get();
            // dd( $particiPant_reg_group->pluck('id')->toArray() );

            $child_items_group = RegistrationGroup::getRegItemsForSelection( $particiPant_reg_group->pluck('id')->toArray() )->get();

            $selected_items_group = RegistrationGroup::getRegItemsForSelectionEdit($provider->id, $participant->user_id)->get();
                    
            return view('admin.operationalForms.edit', compact( 'participantController', 'form', 'provider', 'registeration_group', 'particiPant_reg_group',  'meta','formAction', 'participant', 'readOnly', 'child_items_group', 'selected_items_group'));
        }
        
        // For Support Worker Forms
        if(  $user->roles()->get()->contains( config('ndis.support_worker_role_id') ) && in_array($form->template_id, $this->workerOnlyTemplate) ) {
            
            $participant = \App\SupportWorker::where('support_workers_details.user_id', $form->user_id)->first();
            
            $participant->load('reg_grps');
            
            $registration_groups = \App\RegistrationGroup::getInhouseByProvider($provider->id)->pluck('title','id');
            
            $roleName = trans('opforms.fields.support_worker');
            $agreementName = 'support';

            return view('admin.operationalForms.edit', compact( 'participantController', 'form', 'provider', 'registration_groups', 'meta','formAction', 'participant', 'readOnly', 'agreementName', 'roleName'));
        }

        // For External Support Worker Forms
        if(  $user->roles()->get()->contains( config('ndis.external_service_role_id') ) && in_array($form->template_id, $this->externalOnlyTemplate) ) {
            
            $participant = \App\ServiceProvider::where('service_provider_details.user_id', $form->user_id)->first();
            
            $participant->load('reg_grps');

            $registration_groups = \App\RegistrationGroup::getExternalByProvider($provider->id)->pluck('title','id');
            
            $roleName = trans('opforms.fields.ext_service_provider');
            $agreementName = 'service';

            return view('admin.operationalForms.edit', compact( 'participantController', 'form', 'provider', 'registration_groups', 'meta','formAction', 'participant', 'readOnly', 'agreementName', 'roleName'));
        }

        //If Incident Report
        if( $form->template_id == 8 ){
            
        }
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOperationalFormsRequest $request, $id)
    {
        
        abort_unless(\Gate::allows('participant_edit'), 403);

        $template_id = $request->input('template_id');
        
        //Perform validation
        $validator = $this->validateForm( $request, $template_id );

        // if(isset($validator)):
        //     if($validator->fails()):
        //         $messages = $validator->customMessages;
        //         return redirect()->back()->withErrors($messages);
        //     endif;
        // endif;

        $meta_fields = $request->input('meta',[]);

        foreach($meta_fields as $key => $val) {
            $opMeta = OpformMeta::firstOrNew( ['opform_id' => $id, 'meta_key'=>$key ] );
            $opMeta->meta_value = serialize($val);
            $opMeta->save();
        }

         //Perform tasks based on template ID
         switch( intval($template_id) ){
            case 1:
                $this->maybeSaveParticipantData($request); 
                // Maybe Save Guardian Data
                $this->maybeSaveGuardian($request);
            break;
            case 2:
                // Maybe Save Participant Data
                $this->maybeSaveParticipantData($request);
            break;
            case 3:
            break;
            case 4:
            break;
            case 5:
            break;
            case 6:
            break;
            case 7:
            break;
            case 8:
            break;
            case 9:
            break;
            case 10:
            break;
            case 11:
                // Maybe Save Participant Data
                $this->maybeSaveParticipantData($request);
                $this->saveParticipantRegGroups($request);
                $this->checkAgreementSigned($request);
            break;
            case 12:
            break;
            case 13:
                $this->saveSupportServiceRegGroups($request);
                $this->checkAgreementSigned($request);
            break;
        }


        // pr($meta_fields, 1);


         //there we check if store method call from partifipant controller if yes then redirect to participant
         if ( $request->get('participant_controller', 0) ) {
            $route = route('admin.participants.edit', [ \App\Participant::where('participants_details.user_id', (int)$request->input('user_id') )->first()->id ]);
            return redirect($route);
        }

        //there we check if store method call from partifipant controller if yes then redirect to participant
        if ( $request->get('worker_controller', 0) == '2' ) {
            $route = route('admin.support-workers.edit', [(int)$request->input('user_id')]);
            return redirect($route);
        }

        if ( $request->get('worker_controller', 0) == '3' ) {            
            $route = route('admin.provider.edit', [(int)$request->input('user_id')]);

            return redirect($route);
        }
        


        return redirect('admin/forms');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function importFile()
    {
        $path = public_path('uploads/new_price_guide.csv');

        $handle = fopen($path, 'r');

        $header = null;

        $data = array();
        $flagFound = 0;
        $itemNoMatch = 0;
        $count = 0;
        $foundParentId = 0;
        
        
        while (($row = fgetcsv($handle, 1000, ',')) !== false)
        {
            //pr($row);
            if (!$header)
                $header = $row;
            else
                $data[] = array_combine($header, $row);
        }
        //dd($data);
        foreach($data as $record) {
            
            // $count++;

            // if($count == 4) {
            //     break;
            // }

            $reg_no = ($record['reg_no'] != '') ? $record['reg_no'] : 0;

            if($reg_no){

                $registration_group_name = ($record['registration_group_name'] != '') ? $record['registration_group_name'] : '';
                $support_item_number = ($record['support_item_number'] != '') ? $record['support_item_number'] : '';
                $support_item_name = ($record['support_item_name'] != '') ? $record['support_item_name'] : '';
                $unit = ($record['unit'] != '') ? $record['unit'] : '';
                $price_controlled = ($record['price_controlled'] != '') ? $record['price_controlled'] : '';
                $quote_required = ($record['quote_required'] != '') ? $record['quote_required'] : '';
                $price_limit = ($record['price_limit'] != '') ? $record['price_limit'] : 0;
                $travel = ($record['travel'] != '') ? $record['travel'] : '0';
                $cancellations = ($record['cancellations'] != '') ? $record['cancellations'] : '0';

                $parent = RegistrationGroup::where('item_number', $reg_no)->first();
                
                if(!$parent){
                    $parent = RegistrationGroup::create([
                        'title'=> $registration_group_name, 
                        'item_number'=> $reg_no,
                        'parent_id'=>0, 
                        ]);
                }

                $item = RegistrationGroup::where('item_number', $support_item_number)->first();

                if(!$item){
                    RegistrationGroup::create([
                                                'title'=> $support_item_name,
                                                'item_number'=>$support_item_number, 
                                                'parent_id'=>$parent->id,
                                                'unit'=>$unit, 
                                                'price_controlled'=>$price_controlled, 
                                                'quote_required'=>$quote_required, 
                                                'price_limit'=> preg_replace('/([^0-9\\.])/i','',$price_limit),
                                                'travel'=> $travel,
                                                'cancellations'=> $cancellations,
                        ]);
                }




            }

            

            
        }
        // dd($data);
        
    }


    public function ajaxSARegGrpTable( Request $request )
    {

        abort_unless(\Gate::allows('participant_edit'), 403);

        $data = $request->validate([
            'user_id' => 'required'
        ]);
        
        $provider = \Auth::user();

        $user_id = $request->input('user_id');
        $parentGrp = $request->input('parentGrp');
        $childGrp = $request->input('childGrp');
        
        if($parentGrp && is_array($parentGrp) && !empty($parentGrp)){
            $regGroups = new RegistrationGroup;
            
            $childGroups = $regGroups->getRegItemsForParents($parentGrp, $childGrp)->get();

            $participantGrps =  ParticipantRegGroups::where([ 'user_id'=>(int)$user_id, 'provider_id'=>$provider->id ])->get();

            $participantItems = [];
            foreach($participantGrps as $participantGrp){
                $participantItems[$participantGrp->reg_item_id]['anual'] = $participantGrp->budget;
                $participantItems[$participantGrp->reg_item_id]['monthly'] = $participantGrp->monthly_budget;
                $participantItems[$participantGrp->reg_item_id]['frequency'] = $participantGrp->frequency;
            }
            
            $returnHTML = view('admin.operationalForms.template.11_reggroups', compact('childGroups', 'participantItems') )->render();
        }
        else{
            $childGroups = [];
            $returnHTML = '<tr><td colspan="7">Please Select Registration Groups Above</td></tr>';
        }

        // foreach($childGroups as $childGroup)
        //     pr($childGroup->parent);

        // pr($childGroups);

        
        return response()->json( array('status' => true, 'html'=>$returnHTML ) );

    }

    public function ajaxSARegGrpItems(Request $request) 
    {
        
        abort_unless(\Gate::allows('participant_edit'), 403);

        $data = $request->validate([
            'user_id' => 'required'
        ]);
        
        $provider = \Auth::user();

        $user_id = $request->input('user_id');
        $parentGrp = $request->input('parentGrp');

        if($parentGrp && is_array($parentGrp) && !empty($parentGrp)){
            $regGroups = new RegistrationGroup;
            
            $childGroups = $regGroups->getRegItemsForSelection($parentGrp)->get();
            
            return response()->json( array('status' => true, 'childItems'=>$childGroups ) );    
        }

        

    }
    
}
