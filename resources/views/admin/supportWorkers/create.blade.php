@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('sw.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.support-workers.store") }}" method="POST" class="validated" enctype="multipart/form-data">
            @csrf
            <div class="row">

                {!! 
                    Form::text('first_name', trans('sw.fields.first_name'), old('first_name', isset($supportWorker) ? $supportWorker->first_name : ''))
                    ->id("first_name")
                    ->attrs([ 
                        "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.support_worker.first_name')
                    ])
                    ->size('col-sm-6') 
                !!}

                {!! 
                    Form::text('last_name', trans('sw.fields.last_name'), old('last_name', isset($supportWorker) ? $supportWorker->last_name : ''))
                    ->id("last_name")
                    ->attrs([ 
                        "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.support_worker.last_name')
                    ])
                    ->size('col-sm-6') 
                !!}

                {!! 
                    Form::text('email', trans('sw.fields.email'), old('email', isset($supportWorker) ? $supportWorker->email : ''))
                    ->id("email")
                    ->attrs([ 
                        "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.support_worker.email'),
                        "data-rule-email"=>"true",
                        "data-msg-email"=>trans('errors.support_worker.email_format')
                    ])
                    ->size('col-sm-6') 
                !!}

                {!! 
                    Form::text('mobile', trans('sw.fields.mobile'), old('mobile', isset($supportWorker) ? $supportWorker->user->mobile : '') )
                    ->id("ndis_number")
                    ->attrs([ 
                        "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.support_worker.mobile'),
                        "data-rule-minlength"=>"10",
                        "data-rule-number" => "true",
                        "data-msg-minlength"=>trans('errors.support_worker.mobile_minlength')
                    ])
                    ->size('col-sm-6')
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
                            ->size('col-sm-12') 
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
                                        <option value="{{ $id }}" {{ (isset($supportWorker) && $supportWorker->registration_groups ? $supportWorker->registration_groups->id : old('registration_groups_id')) == $id ? 'selected' : '' }}>{{ $registration_groups }}</option>
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

                {{-- <div class="col-sm-12">
                    <b>You will be charged $15 against </b></br>
                    <b>**** ***** **** {{ $defaultPaymentMethod->card->last4 }}</b>
                    <b>{{ strtoupper($defaultPaymentMethod->card->brand) }}</b></br>
                    <b>You can add a card or change default card </b>
                    <a href="{{ route('admin.subscription') }}">here<a>
                    <input type="hidden" name="method_id" value="{{ $defaultPaymentMethod->id }}"/>
                </div> --}}

                
            
            </div>
            <div>
                <button class="btn btn-primary rounded mt-button" type="submit" value="{{ trans('supportWorkers.fields.create') }}">{{ trans('global.Support_Worker.create_Support_Worker_button') }}</button>
            </div>
            </div>
</div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    $(document).ready(function() {
        var count_support_worker_registration_groups = $("#registration_groups :selected").length;
        $('.count_support_worker_registration_groups').text(count_support_worker_registration_groups);
        

        $('select#registration_groups').on('change', function () {
            var count_support_worker_registration_groups = $("option:selected", this).length;
            $('.count_support_worker_registration_groups').text(count_support_worker_registration_groups);
            // console.log(count_registration_groups_selected_options);
        });
    });
    
</script>
@endsection