@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{-- {{ trans('global.edit') }} {{ trans('global.user.title_singular') }} --}}
        {{ trans('global.provider.edit') }}
    </div>

    @if( !($onboardingStatus) )
    <h5 class="text-center">{{ trans('global.provider.onboarding.message') }}</h5>
    @endif

    <div class="card-body">
        <form action="{{ route('admin.users.profile.update') }}" method="POST" class="validated" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">

                    {!! 
                        Form::text('first_name', trans('global.user.fields.first_name'), old('first_name', isset($user) ? $user->first_name : '') )
                        ->id("first_name")
                        ->size('col-sm-6')
                        ->attrs([
                                "data-rule-required"=>"true",
                                "data-msg-required"=>trans('errors.register.fname')
                            ])
                    !!}


                    {!! 
                        Form::text('last_name', trans('global.user.fields.last_name'), old('last_name', isset($user) ? $user->last_name : '') )->id("last_name")->size('col-sm-6')
                            ->attrs([
                                "data-rule-required"=>"true",
                                "data-msg-required"=>trans('errors.register.lname')
                            ])
                        
                    !!}


                    {!! 
                        Form::text('email', trans('global.user.fields.email'), old('email', isset($user) ? $user->email : '') )
                        ->id("email")->size('col-sm-6')
                        ->attrs([
                                    "data-rule-required"=>"true", 
                                    "data-rule-email"=>"true", 
                                    "data-msg-required"=>trans('errors.register.email'),
                                    "data-msg-email"=>trans('errors.register.email_format')  
                                ])
                    !!}
                

                    {!! 
                        Form::password('password', trans('global.user.fields.password') )->id("password")->size('col-sm-6')->placeholder('****')->autocomplete('new-password')
                            ->attrs([
                                    "data-rule-minlength"=>"6",
                                    "data-msg-minlength"=>trans('errors.pass_length'),
                                ])
                    !!}

                    {!! 
                        Form::text('mobile', trans('global.user.fields.mobile'), old('mobile', isset($user) ? $user->mobile : '') )->id("mobile")->size('col-sm-6')
                        ->attrs([
                            "required"=>"required",
                            "data-rule-required"=>"true",
                            "data-msg-required"=>"Please enter your mobile number",
                            "data-rule-minlength"=>"10",
                            "data-rule-number" => "true",
                            "data-msg-minlength"=>"Mobile number should be 10 digits minimum"
                        ])
                    !!}

                    {!! 
                        Form::text('business_name', trans('global.user.fields.business_name'), old('business_name', isset($user) ? $user->provider->business_name : '') )
                        ->id("business_name")->size('col-sm-6')
                        ->attrs([
                            "required"=>"required",
                            "data-rule-required"=>"true",
                            "data-msg-required"=>trans('errors.register.business'),
                        ])
                    !!}


                    {!! 
                        Form::text('organisation_id', trans('global.user.fields.org_id'), old('organisation_id', isset($user) ? $user->provider->organisation_id : '') )
                        ->id("organisation_id")->size('col-sm-6')
                        ->attrs([
                            "required"=>"required",
                            "data-rule-required"=>"true",
                            "data-msg-required"=>trans('errors.register.org_id'),
                            "data-rule-number"=>"true",
                            "data-msg-number"=>trans('errors.register.org_id_invalid'),
                            
                        ])
                    !!}


                    {!! 
                        Form::text('ra_number', trans('global.user.fields.ra_number'), old('ra_number', isset($user) ? $user->provider->ra_number : '') )
                        ->id("ra_number")->size('col-sm-6')
                        ->attrs([
                            "required"=>"required",
                            "data-rule-required"=>"true",
                            "data-msg-required"=>trans('errors.register.ra_number'),
                        ])
                    !!}


                    {!! 
                        Form::date('renewal_date', trans('global.user.fields.renewal_date'), old('renewal_date', isset($user) ? $user->provider->renewal_date : '') )
                        ->id("renewal_date")->size('col-sm-6')
                        ->attrs([
                            "required"=>"required",
                            "data-rule-required"=>"true",
                            "data-msg-required"=>trans('errors.register.renewal'),
                            "data-rule-dateFormat"=>"true",
                            "data-msg-dateFormat"=>trans('errors.register.date_format')
                        ])
                    !!}


                    {!! 
                        Form::file('ndis_cert', trans('global.user.fields.ndis_cert'), old('ndis_cert', isset($user->provider->ndis_cert) ? $user->provider->ndis_cert : ''))
                        ->size('col-sm-6')
                        ->help( isset($user->provider->ndis_cert) ? '<a target="_blank" href="'.getDocumentUrl( $user->provider->ndis_cert ).'">'. trans('global.user.fields.ndis_cert_download') .'</a>' : trans('global.user.fields.ndis_cert_helper')  )
                        ->attrs(
                            isset($user->provider->ndis_cert)?[]:
                        [
                            "required"=>"required",
                            "data-rule-required"=>"true",
                            "data-msg-required"=>"Please select NDIS certificate"
                        ])
                    !!}

                                                
                    {!! 
                        Form::ajaxUpload('avatar', trans('global.user.fields.avatar'), old('avatar', isset($user->avatar) ? getUserAvatar($user->id,true) : null), isset($user->avatar)?$user->avatar:null, [
                        'input_text'=>"Browse",
                        'button_text'=>"Upload",
                        ])->size('col-sm-6')->help( trans('global.user.fields.avatar_helper') )->id("avatar-upload-profile")
                    !!}
                    
                </div>
                


            

                <div id="reg_grp_item_container">
                    
                    @if( $onboardingStatus )
                            @php  
                                $count =  0 ;
                                $houseID = 0;
                            @endphp
                           
                            @forelse($regGrps as $key => $data)
                                    <fieldset class="position-relative">                
                                        
                                        <div class="row remove-reg">
                                            <div>
                                                <span class="close-icon reg_grp_item_remove"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
                                            </div>
                                        </div>
                                        

                                        <div class="row reg_grp_item" rel="{!! $count !!}">

                                            <div class="col-sm-12 form-group mb-2">
                                                <label>{{ trans('global.provider.reg_state') }}</label>
                                                <div class='input-group'>
                                                    {!! App\Http\Controllers\Traits\Common::getStates('state['.$count.']','state_'.$count, $key ) !!}
                                                    <i class='inputicon fa fa-caret-down' aria-hidden='true'></i>
                                                </div>
                                            </div>
                                        
                                            {!! registration_group_dd( 'parent_reg_group['.$count.']','parent_reg_group_'.$count, 'in_house['.$count.']', 'in_house_'.$count, array('count'=>$count,'parent_id'=>$data) ) !!}
                                            
                                           
                                        </div> <!-- end of .reg_grp_item -->
                                    </fieldset>
                                @php  
                                    $count++;
                                @endphp
                            @empty
                           
                            <?php $data = session()->all();   ?>
                            
                            @if(isset($data['_old_input']['parent_reg_group']))

                                @foreach($data['_old_input']['parent_reg_group'] as $key=>$value)
                                    <fieldset>
                                        <div class="row remove-reg">
                                            <div class="col-sm-12 form-group remove-reg-group">
                                                    {{-- <button type="button" id="remove_regrp_{!! $count !!}" rel="{!! $count !!}" class="btn btn-success rounded reg_grp_item_remove">
                                                            {{ trans('global.provider.onboarding.remove_reg') }}
                                                    </button> --}}
                                                <span class="close-icon reg_grp_item_remove"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
                                            </div>
                                        </div>
                                        

                                        <div class="row reg_grp_item" rel="{!! $count !!}">

                                            <div class="col-sm-12 form-group mb-2">
                                                <label>{{ trans('global.provider.reg_state') }}</label>
                                                <div class='input-group'>
                                                    {!! App\Http\Controllers\Traits\Common::getStates('state['.$key.']','state_'.$key, $data['_old_input']['state'][$key] ) !!}
                                                    <i class='inputicon fa fa-caret-down' aria-hidden='true'></i>
                                                </div>
                                            </div>
                                        
                                            {!! registration_group_old_dd( 
                                                    'parent_reg_group['.$key.']',
                                                    'parent_reg_group_'.$key, 
                                                    'in_house['.$key.']', 
                                                    'in_house_'.$key,
                                                    array(
                                                        'count'=>$key,
                                                        'parent_id'=>isset($data['_old_input']['parent_reg_group'][$key]) ? $data['_old_input']['parent_reg_group'][$key]: -1 , 
                                                        'in_house'=>isset($data['_old_input']['in_house'][$key]) ? $data['_old_input']['in_house'][$key] : -1 
                                                    )
                                                )
                                            !!}
                                           
                                        </div>
                                    </fieldset>                                
                                @endforeach

                            @endif

                            @endforelse    
                                     
                    @endif
                    
                </div>
                
                <div class="row">
                     <div class="col-6 form-group">
                     <button class="btn btn-success rounded" type="submit" value="{{ trans('global.save') }}">Save</button>
                    </div>
                    <div class="col-6 form-group text-right">
                        <button type="button" id="add_more_regrp" class="btn btn-primary rounded">
                                {{ trans('global.provider.onboarding.add_new_reg') }}                                
                        </button>
                    </div>
                   
                </div>
            
        </form>
    </div>
</div>

@include('template.regrp_fields')

@endsection


@section('scripts')
@parent
<script>
   jQuery(document).ready(function(){

        $('#btn-avatar-upload-profile').click(function(e){
            e.preventDefault();
            var ele = $(this);
            var file_data = $('#file-avatar-upload-profile').prop('files')[0];
            var form_data = new FormData();
            // console.log(file_data);
            form_data.append('file', file_data);
            form_data.append('user_id', {{ $user->id }} );

            // ndis.addLoader( ele );
            // ndis.bigLoader();
            var request = $.ajax({
                url: "{{ route('admin.users.avatar') }}",              
                method: "POST",
                data:  form_data,
                enctype: 'multipart/form-data',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                processData: false,  // Important!
                contentType: false,
                cache: false,
                beforeSend: function(ele){
                    // ndis.addLoader(e);
                }
            });
            
            request.done(function( msg ) {     
                ndis.success("Image Uploaded");
                var data = JSON.parse(msg);
                ele.parent().find("a.profile-image").hide();
                ele.parent().find("img.profile-image").attr('src',data.url).removeAttr('hidden').show();
                $("span.profileImage").css('background-image', 'url(' + data.url + ')');
                ele.parent().find("#profile_file_id").val(data.name);

                ele.prop("disabled", "disabled");

            });
            
            request.fail(function( jqXHR, textStatus ) {
                console.log(textStatus);
            });
            
        });


        $('.content').on( 'change', '.reg_group', function(e){
            
            var groupID = $(this).attr('id');
            var inHouseID = '';

            groupSplit = groupID.split('_');
            stateEleID = 'state_'+groupSplit[2];
            inHouseID = 'in_house_'+groupSplit[2];
            stateID = $('#'+stateEleID+' :selected').val();
            
            var parentGrp = [];

            $("#"+groupID+" :selected").each(function(i, val){
                parentGrp.push([]);
                parentGrp[i].push($(this).val()); 
                parentGrp[i].push($(this).text()); 
                parentGrp[i].push($(this).data('in-house')); 
            });

            $('#'+inHouseID).find('option').remove();
            
            $(parentGrp).each(function(i,val){
                $('#'+inHouseID).append($("<option></option>").attr("value",val[0]).text(val[1]).prop('selected', val[2]));
            });
             
     

        });

        $('.content').on('change', '.states', function(e){

            var state = $(this).attr('id');
            var stateNameID = $('#'+state+' :selected').val();
            var totalState = $('#reg_grp_item_container fieldset').length;

            stateID = state.split('_');
            for(var i = 0; i< totalState; i++){

                if( i != stateID[1] ) {

                    var matchingStateID = $('#state_'+i+' :selected').val();

                    if(stateNameID == matchingStateID){
                        $('select#'+state+' option').prop("selected",false);
                        alert('This state already selected');                        
                    }
                    
                }

            }
           
        });

        $('.content').on('input', '.entered_price', function(e) {

            var enterCost = $(this).val();

            var cost_limit = $(this).parent().parent().siblings('.price-limit').find('span').text();
            
            if(parseFloat(enterCost) > parseFloat(cost_limit)){
                $(this).focus();
                $(this).val('');
                alert('Enter the amount less than price limit');
            }

            // if(isNaN(parseFloat(enterCost))){
            //     $(this).focus();
            //     $(this).val('');
            // }
           
        });
        

        var max = 0;
        jQuery("#add_more_regrp").on( 'click', function(e){
            e.preventDefault();
            var items = jQuery("#reg_grp_item_container .reg_grp_item").map(function(item, value){
                return $(value).attr('rel');
            });
            console.log(items)
            var count = items.map(function(item,value){
                value > max ? max = value : '';
            })

            var template = ndis.template('repeater');
            var html     = template({count:jQuery("#reg_grp_item_container .reg_grp_item").length});
        
            jQuery("#reg_grp_item_container").append( html );

            ndis.defaultAlways();
        });

        jQuery( "#reg_grp_item_container" ).on( 'click', '.reg_grp_item_remove', function(e){
            e.preventDefault();
            if( jQuery("#reg_grp_item_container .reg_grp_item").length == 1)return alert("Atleast one group is required!"); 

            if (confirm('Are you sure want to delete')) {
                jQuery(this).closest('fieldset').remove();
            }
            
        });
        
        
        @forelse($regGrps as $key => $data)
        @empty
            @if(!isset($data['_old_input']['parent_reg_group']))
                jQuery("#add_more_regrp").trigger('click');
            @endif
        @endforelse
           
    
        $('body').click(".reg_group_id" ,function(e){
            var $clicked = $(e.target);           
            $clicked.siblings('.child-grps').children('.row.child-grps').slideToggle();
            // $(".row.child-grps").slideToggle();
        });

        
   });
   
</script>
@endsection
