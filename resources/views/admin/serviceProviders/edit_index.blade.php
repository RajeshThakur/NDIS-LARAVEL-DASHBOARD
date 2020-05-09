<form action="{{ route("admin.provider.update", [$serviceProvider->id]) }}" method="POST" class="validated" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            {!!
                Form::text('first_name', trans('serviceProvider.fields.first_name'), old('first_name', isset($serviceProvider) ? $serviceProvider->first_name : '') )
                ->id('first_name')
                ->attrs([ 
                    "required"=>"required",
                    "data-rule-required"=>"true",
                    "data-msg-required"=>trans('errors.externalservice.first_name')
                ])
                ->size('col-sm-6')
                ->help(trans('serviceProvider.fields.first_name_helper')) 
            !!}

            {!! 
                Form::text('last_name', trans('serviceProvider.fields.last_name'), old('last_name', isset($serviceProvider) ? $serviceProvider->last_name : '') )
                ->id('last_name')
                ->attrs([ 
                    "required"=>"required",
                    "data-rule-required"=>"true",
                    "data-msg-required"=>trans('errors.externalservice.last_name')
                ])
                ->size('col-sm-6')
                ->help(trans('serviceProvider.fields.last_name_helper')) 
            !!}

            {!! 
                Form::text('email', trans('serviceProvider.fields.email'), old('email', isset($serviceProvider) ? $serviceProvider->email : '') )
                ->id('email')
                ->attrs([ 
                    "required"=>"required", 
                    "data-rule-required"=>"true",
                    "data-rule-email"=>"true",
                    "data-msg-required"=>trans('errors.externalservice.email'),
                    "data-msg-email"=>trans('errors.externalservice.email_format')
                ])
                ->size('col-sm-6')
                ->help(trans('serviceProvider.fields.email_helper')) 
            !!}

            {!! 
                Form::number('mobile', trans('serviceProvider.fields.mobile'), old('mobile', isset($serviceProvider) ? $serviceProvider->mobile : '') )
                ->id('mobile')
                ->attrs([
                    "required"=>"required",
                    "data-rule-required"=>"true",
                    "data-msg-required"=>trans('errors.externalservice.mobile'),
                    "data-rule-minlength"=>"10",
                    "data-rule-number" => "true",
                    "data-msg-minlength"=>trans('errors.externalservice.mobile_minlength')
                ])
                ->size('col-sm-6')
                ->help(trans('serviceProvider.fields.mobile_helper')) 
            !!}

            {!! 
                Form::location(
                    'address', 
                    trans('serviceProvider.fields.address'), 
                    old('location', isset($serviceProvider) ? $serviceProvider->address : ''),
                    old('lat', isset($serviceProvider) ? $serviceProvider->lat : ''),
                    old('lng', isset($serviceProvider) ? $serviceProvider->lng : '')
                )
                ->id('address')
                ->attrs([
                    "required"=>"required", 
                    "data-rule-required"=>"true", 
                    "data-msg-required"=>trans('errors.externalservice.address')
                ])
                ->size('col-sm-12')
                ->help(trans('serviceProvider.fields.address_helper')) 
            !!}

            <div class="form-group col-sm-12{{ $errors->has('registration_groups_id') ? 'has-error' : '' }}">
                <label for="registration_groups">{{ trans('serviceProvider.fields.registration_groups') }}</label>
                <span class="count_service_provider_registration_groups dashb-count"></span>
                <select name="reg_group[]" id="reg_group_id" class="form-control select2" required="required" data-rule="required" data-msg-required="Registration group selection required" multiple="multiple">
                    @foreach($registrationGroups as $id => $title)
                       <option value="{{ $id }}" {{ ($serviceProvider->reg_grps->contains('reg_group_id', $id))?'selected="selected"':'' }}>{{ $title }}</option>
                    @endforeach
                 </select>
                <small class="form-text text-muted">&nbsp;</small>
            </div>

        </div>

        <div>
            {!! 
                Form::submit(trans('global.save'))->attrs(["class"=>"btn btn-primary rounded"]) 
            !!}
            {!! Form::button( trans('global.delete_btn'), 'danger')->attrs(["onclick"=>"return deleteRec();", 'class'=>'rounded ml-30']) !!}

            {{-- <div class="delete-button">
            </div> --}}
            
        </div>

        
    </form>

    @section('scripts')
@parent
<script>
    $(document).ready(function() {
        var count_service_provider_registration_groups = $("#reg_group_id :selected").length;
        $('.count_service_provider_registration_groups').text(count_service_provider_registration_groups);
        // console.log(count_service_provider_registration_groups);
        

        $('select#reg_group_id').on('change', function () {
            var count_service_provider_registration_groups = $("option:selected", this).length;
            $('.count_service_provider_registration_groups').text(count_service_provider_registration_groups);
            // console.log(count_support_worker_registration_groups);
        });
    });
    
</script>
@endsection