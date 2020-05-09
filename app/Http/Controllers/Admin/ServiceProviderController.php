<?php

namespace App\Http\Controllers\Admin;

use App\ServiceProvider;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceProviderRequest;
use App\Http\Requests\UpdateServiceProviderRequest;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Controllers\Traits\Common;
use App\User;
use App\ProviderRegGroups;
use App\RegistrationGroup;
use App\UsersToProviders;
use App\UserRegGroup;
use App\OperationalForms;

class ServiceProviderController extends Controller
{
    use Common;
    public function index(Request $request)
    {
        
        abort_unless(\Gate::allows('external_service_provider_access'), 403);
        $query='';
        if( isset( $request->q ) ){
            // dd($request);
            $query = $request->query('q');
            $serviceProviders = ServiceProvider::Search( trim($request->q) );
            // dd($serviceProviders);
            $size = sizeof($serviceProviders);
            $result = 'result';
            if( $size > 1) $result = 'results';
            $msg = "Found <b>'" .$size ."'</b> ". $result." for your query of <b>'" .$request->q ."'</b>";
            $serviceProviders->search = array( 'message'=>$msg);
        }
        else
            $serviceProviders = ServiceProvider::all();


        // $serviceProviders = ServiceProvider::all();

        $serviceProviders->load('user');

        $registrationGroups = Common::getDropDown('reg_group[]');

        // pr($serviceProviders->toArray(),1);

        return view('admin.serviceProviders.index', compact('serviceProviders','registrationGroups' ));
    }

    public function create()
    {
        abort_unless(\Gate::allows('external_service_provider_create'), 403);
        
        $provider = \Auth::user();
        $registrationGroups = ProviderRegGroups::where('user_id', $provider->id)->where('inhouse', '0')->groupBy('parent_reg_group_id')->pluck('parent_reg_group_id');
        $registrationGroups = RegistrationGroup::whereIn('id', $registrationGroups)->pluck('title','id');

        return view('admin.serviceProviders.create', compact('registrationGroups'));
    }

    public function store(StoreServiceProviderRequest $request)
    {
        abort_unless(\Gate::allows('external_service_provider_create'), 403);
        
        $provider = \Auth::user();
        //dd($request->all());
        // Set Default Fields for DB to save
        $request->request->add([ 'password'=>'empty', 'active'=>1 ]);
        $user = User::create($request->all());
        $user->roles()->sync([5]);

        //save the service provider details
        $serviceProvider =  new ServiceProvider();
        $serviceProvider->user_id = $user->id;
        $serviceProvider->address = $request->input('address');
        $serviceProvider->lat = $request->input('lat');
        $serviceProvider->lng = $request->input('lng');
        $user->serviceProvider()->save($serviceProvider);

        //store Reg Groups
        $regGroup = $request->input('reg_group');
        foreach($regGroup as $value){
            UserRegGroup::create(['reg_group_id'=>$value, 'user_id'=>$user->id, 'provider_id'=>$provider->id]);
        }

        //$serviceProvider->updateRegGroups( $request->input('reg_group', []) );
        
        //update users to provider
        $user2Provider = new UsersToProviders;
        $user2Provider->user_id = $user->id;
        $user2Provider->provider_id = $provider->id;
        $user->UserProvider()->save($user2Provider);

        return redirect()->route('admin.provider.edit',[$user->id])->with('success', trans('msg.service_provider_add.success') );
    }

    public function edit(int $serviceProviderId)
    {
        abort_unless(\Gate::allows('external_service_provider_edit'), 403);

        //check if admin (redirect to show view)
        if( checkUserRole('1') )return redirect()->route('admin.provider.show', [$serviceProviderId]);

        $serviceProvider = ServiceProvider::where('service_provider_details.user_id', $serviceProviderId)->first();
        $serviceProvider->load('reg_grps');

        $activeTabInfo = $this->getActiveTab();

        $provider = \Auth::user();
        $registrationGroups = ProviderRegGroups::where('user_id', $provider->id)->where('inhouse', '0')->groupBy('parent_reg_group_id')->pluck('parent_reg_group_id');
        $registrationGroups = RegistrationGroup::whereIn('id', $registrationGroups)->pluck('title','id');
        
        // $registrationGroups = Common::getDropDown('reg_group[]', 'reg_group_id', null, ['multiple'=>'multiple', 'class'=>'select2'] );
        return view('admin.serviceProviders.edit', compact('registrationGroups', 'activeTabInfo', 'serviceProvider'));
    }

    public function update(UpdateServiceProviderRequest $request, int $serviceProviderId)
    {
        abort_unless(\Gate::allows('external_service_provider_edit'), 403);

        $serviceProvider = ServiceProvider::where('service_provider_details.user_id', $serviceProviderId)->first();

        $serviceProvider->load('user');
        
        $serviceProvider->update($request->all());
        
        //Update Reg Groups
        $serviceProvider->updateRegGroups( $request->input('reg_group', []) );

        //Update User Fields
        $serviceProvider->user()->update([
            'first_name'=>$request->input('first_name',$serviceProvider->user->first_name),
            'last_name'=>$request->input('last_name',$serviceProvider->user->last_name),
            'email'=>$request->input('email',$serviceProvider->user->email),
            'mobile'=>$request->input('mobile',$serviceProvider->user->mobile)
        ]);

        return redirect()->route('admin.provider.index')->with('success', trans('msg.service_provider_update.success'));
    }

    public function show(ServiceProvider $serviceProvider , $serviceProviderId)
    {
        abort_unless(\Gate::allows('external_service_provider_show'), 403);

        $serviceProvider = ServiceProvider::where('service_provider_details.user_id', $serviceProviderId)->first();

        $serviceProvider->load('reg_grps');

        return view('admin.serviceProviders.show', compact('serviceProvider'));
    }

    public function destroy(ServiceProvider $serviceProvider)
    {
        abort_unless(\Gate::allows('external_service_provider_delete'), 403);

        $serviceProvider->delete();

        $serviceProviders = ServiceProvider::all();

        $serviceProviders->load('user');
        // return back();
        return view('admin.serviceProviders.index', compact('serviceProviders' ))->with('success', trans('msg.service_provider_delete.success') );

    }

    // Documents Section

    public function documents( $serviceProviderId )
    {
        abort_unless(\Gate::allows('participant_edit'), 403);

        $serviceProvider = ServiceProvider::where('service_provider_details.user_id', $serviceProviderId)->first();

        $serviceProvider->load('reg_grps');

        $opforms = OperationalForms::ServiceProvider( $serviceProviderId )->get();
        
        $activeTabInfo = $this->getActiveTab();

        return view( 'admin.serviceProviders.edit', compact('serviceProvider', 'opforms',  'activeTabInfo') );
    }

    
    private function getActiveTab(){
        
        $activeTabInfo = [ 'tab'=>'edit', 'file'=>"admin.serviceProviders.edit_index", "title" => trans('participants.tabs.details') ];

        if ( request()->is('admin/service/provider/*/onboarding') ):
            
            $activeTabInfo = [ 'tab'=>'edit', 'file'=>"admin.serviceProviders.edit_index", "title" => trans('participants.tabs.details') ];

        elseif ( request()->is('admin/service/provider/*/documents') ):
            
            $activeTabInfo = [ 'tab'=>'documents', 'file'=>"admin.serviceProviders.edit_documents", "title" => trans('documents.title') ];
        
        endif;

        return $activeTabInfo;
    }

    public function onboarding_steps( Request $request )
    {
        
        $step = $request->input('step');
        
        switch( intval($step) ){

            case 1:
                
                $data = $request->validate([
                                                'provider_agreement' => 'required',
                                                'user_id' => 'required',
                                                'step' => 'required'
                                            ]);

                $serviceProvider = new ServiceProvider;

                //Fetch User data
                $serviceProvider = $serviceProvider->getServiceProvider( $data['user_id'] );
                
                
                if( !$serviceProvider ){
                    return [ 'status'=>false, 'message'=>'Invalid Submission! please try again later.' ];
                }

                $next_step = 2;
                 
                    //Update the serviceProvider with given values
                $serviceProvider->where('service_provider_details.user_id', $serviceProvider->user_id)->update([ 'onboarding_step'=> $next_step ]);
                
                if( $data['provider_agreement'] ){
                    $form_id = 13;
                    $agreement_link = route("admin.forms.create", [$form_id, $serviceProvider->user_id, $isParticipantTrue=3]); 
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

                $serviceProvider = new ServiceProvider;

                //Fetch User data
                $serviceProvider = $serviceProvider->getServiceProvider( $data['user_id'] );
                
            
                if( !$serviceProvider ){
                    return [ 'status'=>false, 'message'=>'Invalid Submission! please try again later.' ];
                }

                if($serviceProvider->is_onboarding_complete)
                    $next_step = 5;
                else
                    $next_step = 1;
                 
                    //Update the serviceProvider with given values
                $serviceProvider->where('service_provider_details.user_id', $serviceProvider->user_id)->update([ 'onboarding_step'=> $next_step ]);
                
                return [ 'status'=>true, 'type'=>'popup', 'next_step'=>5 ];
                
                    
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
        
        $serviceProvider = new ServiceProvider;

        //Fetch User data
        $serviceProvider = $serviceProvider->getServiceProvider( $data['user_id'] );
        
        if( !$serviceProvider ){
            return [ 'status'=>false, 'message'=>'Invalid Submission! please try again later.' ];
        }
      
        return [ 'status'=>true, 'type'=>'popup', 'next_step'=>$serviceProvider->onboarding_step ];
    
    } 


}
