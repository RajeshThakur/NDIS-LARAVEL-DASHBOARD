<?php
/**
 * TRait for  Operational Forms Model
 */
namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\RegistrationGroup;
use App\ParticipantRegGroups;
use App\SupportWorker;
use App\ServiceProvider;

use Notification;
use App\Notifications\GuardianAdded;
use App\Notifications\GuardianActivation;

trait OpformTrait
{
    /**
     * Fetch User Agreement
     *
     * @param Request $request
     */
    public function participantAgreement( $user_id )
    {
        try{
            $user = \App\User::findOrFail($user_id);
            if( $user->roles()->get()->contains(1) ){
                
            }
            return null;
        }
        catch(ModelNotFoundException $e)
        {
            return null;
        }
        catch(Exception $e){
            return null;
        }
    }


    /**
     * Fetch MetaData From DB in an associative array format
     */
    public function getMeta(){
        // $this->meta();
    }

    /**
     * Save The Guardian Data if Template is for Guardian Agreement
     */
    public function maybeSaveGuardian( $request )
    {
        $participantId = (int)$request->input('user_id');

        $meta_fields = $request->input('meta',[]);

        $guardian = \App\Guardian::where('user_id', $participantId)->first();

        if(!$guardian){

            if( !empty($meta_fields) ){

                \App\Guardian::insert([
                                                [
                                                    'name'       => $meta_fields['advocate_name'], 
                                                    'address'    => $meta_fields['advocate_address'], 
                                                    'lat'        => $meta_fields['advocate_lat'], 
                                                    'lng'        => $meta_fields['advocate_lng'], 
                                                    'phone'      => $meta_fields['advocate_phone'], 
                                                    'mobile'     => $meta_fields['advocate_mobile'], 
                                                    'email'      => $meta_fields['advocate_email'],
                                                    'password'   => 'Hash::make(12345)', 
                                                    'user_id'    => $participantId,
                                                    'token'      => str_random(60)
                                                ]
                                            ]);
    
                $guardian = \App\Guardian::where('user_id',$participantId)->first();

                $participant = \App\Participant::where('participants_details.user_id',$participantId)->first();
                
                $participant->update(['participants_details.guardian_id'=>$guardian->id, 'participants_details.using_guardian'=>1 ]);
                
                // Confirmation email to Participant
                $participant->notify(new GuardianAdded($guardian));

                // Activation email for Guardian
                $guardian->notify(new GuardianActivation());
    
            }
        }
        // dd('die');
    }


    /**
     * Save The Guardian Data if Template is for Guardian Agreement
     */
    public function maybeSaveParticipantData( $request ){

        $participantId = (int)$request->input('user_id');
        $meta_fields = $request->input('meta',[]);
        $budget_funding = $request->input('budget_funding',0);

        if($budget_funding){
            \App\Participant::where('participants_details.user_id', $participantId )
                ->update([
                            'budget_funding' => $budget_funding,
                            'funds_balance' => $budget_funding
                        ]);
        }


        if(!empty($meta_fields) && !empty($meta_fields['participant_phone'])){
            \App\User::where('id', $participantId )
                ->update([
                            'mobile' => $meta_fields['participant_phone'] 
                        ]);
        }
        
        if(!empty($meta_fields) && !empty($meta_fields['client_goal'])){
            \App\Participant::where('participants_details.user_id', $participantId )
                ->update([
                            'participant_goals' => $meta_fields['client_goal']
                        ]);
        }

    }
    
    /**
     * Save The Participant Registration Group if Template is for NDIS Agreement
     */
    public function saveParticipantRegGroups( $request ){
        
        $provider = \Auth::user();
        $participantId = (int)$request->input('user_id');
        $parent_reg_grps = $request->input('registeration_group');
        $child_reg_grps = $request->input('child_items_group');
        
        
        $regGrp_anual = $request->input('regGrp_anual',[]);
        $regGrp_monthly = $request->input('regGrp_monthly',[]);
        $regGrp_frequency = $request->input('regGrp_frequency');

        $regItems = RegistrationGroup::getRegItemsForParents($parent_reg_grps, $child_reg_grps)->get();

        // pr($regGrp_monthly);
        // pr($regGrp_anual, 1);

        // Remove all existing Participant Reg Groups
        ParticipantRegGroups::where([ 'user_id'=>(int)$participantId, 'provider_id'=>$provider->id ])->delete();

        foreach($regItems as $regItem){

            if(is_array($regGrp_anual) && !empty($regGrp_anual) ){
                $budget = isset($regGrp_anual[$regItem->id])?$regGrp_anual[$regItem->id]:0;
            }
            else
                $budget = 0;        
            
            
            if(is_array($regGrp_monthly) && !empty($regGrp_monthly) ){
                $monthlyBudget   = isset($regGrp_monthly[$regItem->id])?$regGrp_monthly[$regItem->id]:0;
            }
            else
                $monthlyBudget = 0;

            if(is_array($regGrp_frequency) && !empty($regGrp_frequency) ){
                $frequency = isset($regGrp_frequency[$regItem->id])?$regGrp_frequency[$regItem->id]:0;
            }
            else
                $frequency = 0;

            ParticipantRegGroups::create([
                                            'reg_group_id' => $regItem->parent_id,
                                            'reg_item_id' => (int) $regItem->id,
                                            'user_id'=>(int)$participantId,
                                            'provider_id'=>$provider->id,
                                            'budget'=>(float)$budget,
                                            'anual_funds_balance'=>(float)$budget,
                                            'monthly_budget'=>(int)$monthlyBudget,
                                            'frequency'=> $frequency
                                        ]);
            
        }

    }

    public function participantAgreements( $user_id ){
        $opform_tmpl_id = config('ndis.forms.particpant_agreement_id');
        return \App\OperationalForms::where([
                                'user_id'=> $user_id,
                                'template_id'=> $opform_tmpl_id
                            ]);
    }

    public function isParticipantAgreementSigned( $participantId, $provider_id ){

        $agreement_form = $this->participantAgreements($user_id)->where('provider_id', $provider_id)->first();
        // dd($agreement_form);
        return $agreement_form;

    }

    public function swAgreements( $user_id ){
        $opform_tmpl_id = config('ndis.forms.support_worker_agreement_id');
        return \App\OperationalForms::where([
                                'user_id'=> $user_id,
                                'template_id'=> $opform_tmpl_id
                            ]);
    }

    public function isSWAgreementSigned( $swId, $provider_id ){
        
        return $agreement_form = $this->swAgreements($user_id)->where('provider_id', $provider_id)->first();
        
    }

     /**
     * Save The Support Worker/Service Provider Registration Group if Template is for Support/Service Agreement
     */
    public function saveSupportServiceRegGroups( $request ){

        $agreement_with = $request->input('agreement_with');

        $provider = \Auth::user();

        $user_id = (int)$request->input('user_id');
        
        if($agreement_with === 'support'){
            $supportWorker = SupportWorker::where('support_workers_details.user_id',$user_id)->first();
            //Update Reg Groups
            $supportWorker->updateRegGroups($provider->id, $request->input('registeration_group', []) );

            if($request->filled('meta.worker_signature')){
                \App\SupportWorker::where('support_workers_details.user_id', (int)$request->input('user_id'))
                                    ->update(['agreement_signed' => 1]);
            }
        } else { 
            $serviceProvider = ServiceProvider::where('service_provider_details.user_id', $user_id)->first();
            
            $serviceProvider->updateRegGroups( $request->input('registeration_group', []) );

            if($request->filled('meta.worker_signature')){
                \App\ServiceProvider::where('service_provider_details.user_id', (int)$request->input('user_id'))
                                    ->update(['agreement_signed' => 1]);
            }
        }
        

    }

    //check if participant/supportworker/external service provider signed the agreement if yes then update their database to signed yes//
    public function checkAgreementSigned($request)
    {
         if( $request->filled('meta.participant_signature') ){
            \App\Participant::where('participants_details.user_id', (int)$request->input('user_id'))
                                ->update(['agreement_signed' => 1]);
        }

        if( $request->filled('meta.worker_signature') ){
            \App\SupportWorker::where('support_workers_details.user_id', (int)$request->input('user_id'))->update(['agreement_signed' => 1, 'onboarding_step'=>2]);
        }

        if($request->filled('meta.worker_signature')){
            \App\ServiceProvider::where('service_provider_details.user_id', (int)$request->input('user_id'))
                                ->update(['agreement_signed' => 1]);
        }
        
    }



    
}