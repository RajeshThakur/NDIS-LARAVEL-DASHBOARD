@extends('layouts.app')
@section('content')



<div class="signout-box">
    <div class="col-sm-8 offset-2">
        @include('partials.message')
    </div>
<div class="login-box">

    <div class="authbox sign-up-form">
    <div class="card">
        <div class="card-body login-card-body">
            <form method="POST" action="{{ route('register') }}" autocomplete="nope" class="validated" enctype="multipart/form-data">
                <h2> {{ trans('global.signUp') }}</h2>
                {{ csrf_field() }}
                    
                {!! 
                    Form::text('first_name', 'First Name', old('first_name') )
                        ->attrs([
                            "data-rule-required"=>"true",
                            "data-msg-required"=>trans('errors.register.fname')
                        ])
                !!}
                   
                {!! 
                    Form::text('last_name', 'Last Name', old('last_name'))
                        ->attrs([
                            "data-rule-required"=>"true",
                            "data-ms
                            g-required"=>trans('errors.register.lname')
                        ])
                !!}

                {!! 
                    Form::text('email', 'Email', old('email') )
                         ->attrs([
                            "data-rule-required"=>"true",
                            "data-rule-email"=>"true", 
                            "data-msg-required"=>trans('errors.register.email'),
                            "data-msg-email"=>trans('errors.register.email_format')
                        ])
                !!}

                {!! 
                    Form::password('password', "Password ")
                        ->attrs([
                            "data-rule-required"=>"true",
                            "data-msg-required"=>trans('errors.pass'),
                            "data-rule-minlength"=>"6",
                            "data-msg-minlength"=>trans('errors.pass_length'),
                        ])
                !!}

                {!! 
                    Form::password('password_confirmation', "Confirm Password ")
                        ->attrs([   
                            "data-rule-required"=>"true",
                            "data-msg-required"=>trans('errors.confirm'),
                            "data-rule-minlength"=>"6",
                            "data-msg-minlength"=>trans('errors.pass_length'),
                        ])
                !!}
                
                {!! 
                    Form::text('business_name', 'Business Name', old('business_name'))->attrs([
                        "data-rule-required"=>"true",
                        "data-msg-required"=>trans('errors.register.business')
                    ])
                !!}

                <div id="dm-inp-organisation_id" class="col-sm-12">
                    <div class="form-group">
                        <label for="inp-organisation_id " class="">Organisation ID</label>
                        <div class="input-group register-email inp-organisation">
                        <input type="text" name="organisation_id"  value="{{old('organisation_id')}}" id="inp-organisation_id" class="form-control" data-rule-required="true" 
                            data-msg-required="{{trans('errors.register.org_id')}}" data-rule-number="true" data-msg-number="{{trans('errors.register.org_id_invalid')}}" >
                        <i class="inputicon " aria-hidden="true"></i>
                        {{-- <span class="reg-bg">Type Your Id </span> --}}
                    </div>
                    <small class="form-text text-muted">&nbsp;</small>
                </div>
            </div>


                {{-- {!! 
                    Form::text('ra_number', 'RA Number')->attrs(["required"=>"required" ])->placeholder=("* * * * * * * *")
                !!} --}}
                <div id="dm-inp-ra_number" class="col-sm-12">
                    <div class="form-group">
                        <label for="inp-ra_number" class="">RA Number</label>
                        <div class="input-group ra_number-sign">
                            <input type="text" name="ra_number"  value="{{old('ra_number')}}" id="inp-ra_number" data-rule-required="true" data-msg-required="{{trans('errors.register.ra_number')}}" 
                                class="form-control" placeholder="">
                            <i class="inputicon " aria-hidden="true"></i>
                        </div>
                        <small class="form-text text-muted">&nbsp;</small>
                    </div>
                </div>


                {!! 
                    Form::date('renewal_date', 'Renewal Date',  old('renewal_date') )
                    ->attrs([
                            "data-rule-required"=>"true", 
                            'data-msg-required'=>trans('errors.register.renewal'),
                            "data-rule-dateFormat"=>"true",
                            "data-msg-dateFormat"=>trans('errors.register.date_format')
                        ])
                !!}
       

                {!! 
                    Form::file('ndis_cert', 'Upload NDIS Certificate of Registration', old('ndis_cert'))
                        ->id("ndis_cert")
                        ->file_placeholder("")
                        // ->attrs(["required"=>"required", "data-rule-required"=>"true", "data-rule-file"=>"true", "data-msg-required"=>"Please upload certificate" ])
                !!}                    


                {!! 
                    Form::checkbox('tnc', '<p style="color: inherit;">I have read and agree to <a target="_blank" href="https://www.ndiscentral.org.au/terms-of-use">NDIS Central\'s Terms of Use.</a></p>','1')
                    ->id("defaultLoginFormRemember")
                    ->attrs(["required"=>"required", "data-msg-required"=>trans('errors.register.terms')])
                !!}


                </div>
                <div class="row">
                    <div class="col-12 text-right">
                        <button type="submit" class="btn btn-success btn-block rounded mt-button button2" data-text="SignUp">
                            <span>{{ trans('global.signUp') }}</span>
                        </button>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-sm-12">
                    <p class="mb-1 forget-password mt-4 pl-3">{{ trans('global.pages.signup.already') }}
                        <a class="" href="{{ route('login') }}">
                             <u> {{ trans('global.login') }}</u>
                        </a>
                       {{-- <span>|</span>
                        <a class="" href="{{ route('password.request') }}">
                            {{ trans('global.forgot_password') }}
                        </a> --}}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


</div>
@endsection

@section('scripts')
@parent
    <script>
        $(function () {
            $("#datepicker").datepicker({ 
                autoclose: true, 
                todayHighlight: true
            }).datepicker('update', new Date());
            });
    </script>

@endsection