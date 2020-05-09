    <form action="{{ route("admin.support-workers.update", [$supportWorker->user_id]) }}" method="POST" class="validated" enctype="multipart/form-data" id="sw-profile">
        @csrf
        @method('PUT')
        <div class="row form-mt">

            {!! 
                Form::text('first_name', trans('sw.fields.first_name'), old('first_name', isset($supportWorker) ? $supportWorker->first_name : '') )
                ->id("first_name")
                ->attrs([ 
                    "required"=>"required", 
                    "data-rule-required"=>"true", 
                    "data-msg-required"=>trans('errors.support_worker.first_name')
                ])
                ->size('col-sm-6')
                ->help(trans('sw.fields.first_name_helper'))
            !!}

            {!! 
                Form::text('last_name', trans('sw.fields.last_name'), old('last_name', isset($supportWorker) ? $supportWorker->last_name : '') )
                ->id("last_name")
                ->attrs([ 
                    "required"=>"required", 
                    "data-rule-required"=>"true", 
                    "data-msg-required"=>trans('errors.support_worker.last_name')
                ])
                ->size('col-sm-6')
                ->help(trans('sw.fields.last_name_helper'))
            !!}


            {!! 
                Form::text('email', trans('sw.fields.email'), old('email', isset($supportWorker) ? $supportWorker->email : '') )
                ->id("email")
                ->attrs([ 
                    "required"=>"required", 
                    "data-rule-required"=>"true", 
                    "data-msg-required"=>trans('errors.support_worker.email'),
                    "data-rule-email"=>"true",
                    "data-msg-email"=>trans('errors.support_worker.email_format')
                ])
                ->size('col-sm-6')
                ->help(trans('sw.fields.email_helper'))
            !!}
        

            {!! 
                Form::text('mobile', trans('sw.fields.mobile'), old('mobile', isset($supportWorker) ? $supportWorker->mobile : '') )
                ->id("mobile")
                ->size('col-sm-6')
                ->attrs([ 
                    "required"=>"required", 
                    "data-rule-required"=>"true", 
                    "data-msg-required"=>trans('errors.support_worker.mobile'),
                    "data-rule-minlength"=>"10",
                    "data-rule-number" => "true",
                    "data-msg-minlength"=>trans('errors.support_worker.mobile_minlength')
                ])
                ->help(trans('sw.fields.mobile_helper'))
            !!}

            {!! 
                Form::location( 'address', 
                                trans('sw.fields.address'),  
                                old('address', isset($supportWorker) ? $supportWorker->address : ''),
                                isset($supportWorker) ? $supportWorker->lat : '',
                                isset($supportWorker) ? $supportWorker->lng : '' 
                                )
                            ->id('address')
                            ->attrs([ 
                                "required"=>"required", 
                                "data-rule-required"=>"true", 
                                "data-msg-required"=>trans('errors.support_worker.address') 
                            ])
                            ->size('col-sm-6') 
            !!}

            {!! 
                Form::ajaxUpload('avatar', trans('sw.fields.avatar'),  (isset($supportWorker->avatar) ? getUserAvatar($supportWorker->user_id,true) : null), (isset($supportWorker->avatar) ? $supportWorker->avatar: null), [
                'input_text'=>"Browse",
                'button_text'=>"Upload",
                ])
                ->size('col-sm-6')
                ->help( trans('global.user.fields.avatar_helper') )
                ->id("profile_file_id") 
            !!}


            <div class="col-sm-12">
                <div class="reg-group">
                    <div class="form-group {{ $errors->has('registration_groups_id') ? 'has-error' : '' }}">
                        <label for="registration_groups">{{ trans('sw.fields.registration_groups') }}</label>
                        <span class="count_support_worker_registration_groups dashb-count"></span>
                            <div class="input-group" data-date-format="dd-mm-yyyy">
                            <select name="registration_groups_id[]" id="registration_groups" required="required" data-rule="required" data-msg-required="Registration group selection required" class="form-control select2" multiple>
                                <option disabled>Select registration group</option>
                                @foreach($registration_groups as $id => $registration_groups)
                                    <option value="{{ $id }}" {{ (in_array($id, old('registration_groups_id', [])) || isset($supportWorker) && $supportWorker->reg_grps->contains( 'reg_group_id', $id )) ? 'selected' : '' }}>{{ $registration_groups }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('registration_groups_id'))
                                <p class="help-block">
                                    {{ $errors->first('registration_groups_id') }}
                                </p>
                            @endif
                            <i class="inputicon fa fa-caret-down" aria-hidden="true"></i>
                            </div>
                    </div>
                </div>
            </div>

            <div>
                <input type="hidden" id="user_id" name="user_id" class="form-control" value="{{ old('user_id', isset($supportWorker) ? $supportWorker->user_id : 0) }}" />
                <input type="hidden" id="provider_id" name="provider_id" class="form-control" value="{{ old('provider_id', isset($supportWorker) ? $supportWorker->provider_id : 0) }}" />
            </div>
            
            <div class="custom-support">
            <div class="save-btn">
                <button class="btn btn-primary plr-100 rounded mt-40" type="submit" value="Save">{{ trans('global.save') }}</button>
            </div>

            @can('support_worker_delete')
            <div class="delete-button">
                {!! Form::button( trans('global.delete_btn'), 'danger')->attrs(["onclick"=>"return deleteRec();", 'class'=>'rounded mt-40']) !!}
            </div>
        @endcan
        </div>
       

    </form>

    @can('support_worker_delete')
        @include('template.deleteItem', [ 'destroyUrl' => route('admin.support-workers.destroy', $supportWorker->sw_id) ])
    @endcan
        

@section('scripts')
@parent
<script>
   jQuery(document).ready(function(){

        var count_support_worker_registration_groups = $("#registration_groups :selected").length;
        $('.count_support_worker_registration_groups').text(count_support_worker_registration_groups);

        $('select#registration_groups').on('change', function () {
            var count_support_worker_registration_groups = $("option:selected", this).length;
            $('.count_support_worker_registration_groups').text(count_support_worker_registration_groups);
            // console.log(count_registration_groups_selected_options);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $('#avatar-tag').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#avatar").change(function(){
            readURL(this);           
            $('#avatar-upload').prop("disabled", false);
        });

        $('#btn-profile_file_id').click(function(e){
            e.preventDefault();

            //remove thisline when AWS is fixed
            $("#profile_file_id").val('12345');
            var ele = $(this);
            var file_data = $('#file-profile_file_id').prop('files')[0];
            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('user_id', {{ $supportWorker->user_id }} );
            ndis.addLoader( ele );        
            var request = $.ajax({
                url: "{{ route('admin.users.avatar') }}",
                method: "POST",
                data:  form_data,
                enctype: 'multipart/form-data',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                processData: false,  // Important!
                contentType: false,
                cache: false,
            });
            
            request.done(function( msg ) {        
                var data = JSON.parse(msg);
                $("#profile_file_id").val(data.id);
                ndis.removeLoader(ele);
                
            });
            
            request.fail(function( jqXHR, textStatus ) {
                console.log(textStatus);
            });
        });
    
   });
   function deleteRec(){
        if(confirm('{{ trans('global.areYouSure') }}') ){
            document.getElementById('deleteRec').submit();
        }
        return false;
    }
</script>
@endsection