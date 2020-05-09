@extends('layouts.app')
@section('content')
<div class="signout-box">
   <div class="login-box">
      <!-- <div class="login-logo">
         <div class="login-logo">
             <a href="#">
                 {{ trans('global.site_title') }}
             </a>
         </div>
         </div> -->
      <div class="sign-up-form">
         <div class="card">
            <div id="accordion">
               <div class="custom-card" id="headingOne">
                  <h2 class="custom-collapse" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                     {{ trans('global.signUp') }}
                  </h2>
                  <span class="arrow-bottom"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
               </div>
               <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                  <div class="card-body login-card-body">
                     <form method="POST" action="{{ route('register') }}" class="validated" enctype="multipart/form-data">
                       {{-- <h2> {{ trans('global.signUp') }}</h2> --}}
                        {{ csrf_field() }}
                        {!! 
                        Form::text('first_name', 'First Name', old('first_name') )->attrs([
                        "data-rule-required"=>"true",
                        "data-msg-required"=>trans('errors.register.fname')
                        ])
                        !!}
                        {!! 
                        Form::text('last_name', 'Last Name', old('last_name'))->attrs([
                        "data-rule-required"=>"true",
                        "data-msg-required"=>trans('errors.register.lname')
                        ])
                        !!}
                        {{-- {!! 
                        Form::text('email', 'Email')->attrs(["required"=>"required" ])
                        !!} --}}
                        <div class="form-group col-sm-12">
                           <label for="inp-email" class="">Email</label>
                           <div class="input-group register-email">
                              <input type="text" name="email" id="inp-email" value="{{old('email')}}" class="form-control" data-rule-required="true" data-rule-email="true" 
                                 data-msg-required="Please enter your email address" data-msg-email="{{trans('errors.register.email')}}" >
                              <i class="inputicon " aria-hidden="true"></i>
                              {{-- <span class="reg-bg">Type Your E-mail </span> --}}
                           </div>
                           <small class="form-text text-muted">&nbsp;</small>
                        </div>
                        {!! 
                        Form::password('password', "Password ")->attrs([
                        "data-rule-required"=>"true",
                        "data-msg-required"=>trans('errors.pass')
                        ])
                        !!}
                        {!! 
                        Form::password('password_confirmation', "Confirm Password ")->attrs([
                        "data-rule-required"=>"true",
                        "data-msg-required"=>trans('errors.pass_confirm')
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
                        ->attrs(["data-rule-required"=>"true", 'data-msg-required'=>trans('errors.register.renewal') ])
                        !!}
                        {!! 
                        Form::file('ndis_cert', 'Upload NDIS Certificate of Registration', old('ndis_cert'))->id("ndis_cert")->attrs(["required"=>"required", "data-msg-required"=>trans('errors.register.ndis_cert')])->file_placeholder("")
                        !!}                    
                        {{-- {!! 
                        Form::checkbox('tnc', '
                        <p style="color: inherit;" href="https://www.ndiscentral.org.au/terms-of-use">I have read and agree to <a href="#">NDIS Central\'s Terms of Use.</a></p>
                        ','1')
                        ->id("defaultLoginFormRemember")
                        ->attrs(["required"=>"required", "data-msg-required"=>trans('errors.register.terms')])
                        !!} --}}
                  </div>
                </form>
                  {{-- <div class="">
                    <div class="col-12 text-right">
                        <button type="submit" class="btn btn-success btn-block rounded mt-button button2" data-text="SignUp">
                        <span>{{ trans('global.signUp') }}</span>
                        </button>
                    </div>
                  </div>
                  </form>
                  <div class="">
                     <div class="col-sm-12">
                        <p class="mb-1 forget-password mt-4">
                           <a class="" href="{{ route('login') }}">
                           {{ trans('global.login') }}
                           </a>
                        </p>
                     </div>
                  </div> --}}
               </div>
            
            <div class="custom-card" id="headingTwo">
               <h2 class="custom-collapse collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Add card payment
               </h2>
                <span class="arrow-bottom"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
            </div>
            <div id="collapseTwo" class="custom-card collapse" aria-labelledby="headingTwo" data-parent="#accordion">
               <div class="card-body">
                 hii hii
               </div>
            </div>
            <div class="custom-card" id="headingThree">
               <h2 class="custom-collapse collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    NDIS Central's Terms of Use.
               </h2>
                <span class="arrow-bottom"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
            </div>
            <div id="collapseThree" class="custom-card collapse" aria-labelledby="headingThree" data-parent="#accordion">
               <div class="card-body">
                 <div class="card-body login-card-body">
                     <form method="POST" action="{{ route('register') }}" class="validated" enctype="multipart/form-data">                  
                        {!! 
                        Form::checkbox('tnc', '
                        <p style="color: inherit;" href="https://www.ndiscentral.org.au/terms-of-use">I have read and agree to <a href="#">NDIS Central\'s Terms of Use.</a></p>
                        ','1')
                        ->id("defaultLoginFormRemember")
                        ->attrs(["required"=>"required", "data-msg-required"=>trans('errors.register.terms')])
                        !!}
                        <div class="">
                    <div class="col-12 text-right">
                        <button type="submit" class="btn btn-success btn-block rounded mt-button button2" data-text="SignUp">
                        <span>{{ trans('global.signUp') }}</span>
                        </button>
                    </div>
                  </div>
                  </form>
                  <div class="">
                     <div class="col-sm-12">
                        <p class="mb-1 forget-password mt-4">
                           <a class="" href="{{ route('login') }}">
                           {{ trans('global.login') }}
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