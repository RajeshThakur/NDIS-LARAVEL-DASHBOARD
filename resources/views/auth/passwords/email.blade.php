@extends('layouts.app')
@section('content')


<div class="login-secreen-show dss " style="display: block;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3">
                <div class="login-left-column login-left-column d-flex flex-column ">
                    <img src="/img/logo_2.png">
                   <p class="login-box-msg-text">{{ trans('global.pages.login.subHeading') }}</p>
                </div>
            </div>

            <div class="col-sm-9">
                <div class="authbox  d-flex flex-column ">

                    @include('partials.message')
                    
                    <form method="POST" action="{{ route('password.email') }}" class="validated">

                        <h2>{{ trans('global.reset_password') }}</h2>

                        {{ csrf_field() }}
                        <div>
                            <div class="form-group has-feedback">
                                <input type="email" name="email" class="form-control" required="required" placeholder="{{ trans('global.login_email') }}"  data-rule-required="true" data-rule-email="true" data-msg-required="Please enter your email address" data-msg-email="Follow standard email validation rules">
                                
                            </div>
                        </div>

                            <div class="signin-button">          
                                <button type="submit" class="btn btn-primary btn-block rounded mt-20">
                                    {{ trans('global.reset_password') }}
                                </button>
                            </div>

                    </form> 
                    <div class="row">
                        <div class="col-sm-12">
                            <p class="mb-1 forget-password after-border mt-4">
                                
                                <a class="custom-links" href="{{ route('login') }}">
                                    {{ trans('global.login') }}
                                </a>
                               <span>|</span>
                                <a class="text-center reset-password" href="{{ route('register') }}">
                                    {{ trans('global.register') }}
                                </a>
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
    <script type="text/javascript">
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