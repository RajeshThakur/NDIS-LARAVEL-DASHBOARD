@extends('layouts.app')
@section('content')
 


<div class="login-secreen-show ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3">
                <div class="login-left-column login-left-column d-flex flex-column ">
                    <img src="/img/logo_2.png">
                    <p class="login-box-msg-text">{{ trans('global.pages.login.subHeading') }}</p>
                </div>
            </div>

            <div class="col-sm-9">
                <div class="authbox sign-in-form  d-flex flex-column ">

                    @include('partials.message')

                    <form action="{{ route('login') }}" class="validated" method="POST">

                        <h2>{{ trans('global.signIn') }}</h2>
                        {{ csrf_field() }}


                        {!! 
                            Form::text('email', trans('global.user.fields.email'). '')
                            ->attrs([
                                "data-rule-required"=>"true",
                                "data-msg-required"=>"Please enter your email address",
                                "data-rule-email"=>"true",
                                "data-msg-email"=>"Please enter a valid email address",
                            ])
                            ->placeholder('email@domain.com')
                        !!}

                        {!! 
                            Form::password('password', trans('global.user.fields.password')) ->value("") ->id("myPsw")
                            ->attrs([
                                "data-rule-required"=>"true",
                                "data-msg-required"=>"Please enter your password"
                            ])
                            ->placeholder('*******')
                            
                        !!}
                        <p class="mb-1 forget-password text-right">
                          <a class="" href="{{ route('password.request') }}">
                            {{ trans('global.forgot_password') }}
                        </a>
                        </p>

                        <div class="row">
              
                            <div class="col-12">
                                <div class="signin-button">
                                    <button type="submit" class="btn btn-primary btn-block rounded mt-20">{{ trans('global.signIn') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <p class="mb-1 forget-password mt-2">
                        {{-- <a class="" href="{{ route('password.request') }}">
                            {{ trans('global.forgot_password') }}
                        </a> --}}
                        {{-- <span>|</span> --}}
                        <a class="text-left mt-3" href="{{ route('register') }}">

                            {{ trans('global.register') }}
                        </a>
                    </p>
                </div>
              </div>
      </div>
      </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
 <script type="text/javascript">
        jQuery(document).ready(function(){
          jQuery("button.sign-in").click(function(){
            jQuery(".login-secreen-show").show();
            jQuery(".front-page .login-box").hide();
          });
        });

       
        function myFunction() {
        var x = document.getElementById("input#myPsw").value;
        document.getElementById("demo").innerHTML = x;
        }

         $(function () {
            var totalHeight = $( document ).height() ;
            var screenHeight = $( window ).height() ;
            // console.log( "Document height is : " +totalHeight + ',  Screen height is : ' + screenHeight   );
            var diff = totalHeight - screenHeight -2 ;
            // console.log(diff);
            jQuery(".main-footer").attr('style','margin-top: -'+diff+'px !important');
        });

    </script> 


    
    
    @endsection




