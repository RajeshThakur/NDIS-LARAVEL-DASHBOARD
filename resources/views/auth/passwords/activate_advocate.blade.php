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

                <div class="authbox d-flex flex-column ">

                    @include('partials.message')


                    <form method="POST" action="{{ route('activate.gaurdian') }}"  class="validated">
                        {{ csrf_field() }}

                        <h2>{{ trans('global.reset_password_title') }}</h2>

                        <div>
                            <input name="token" value="{{ $user->token }}" type="hidden" >

                            {!! 
                                Form::password('password', trans('global.user.fields.password') )
                                ->attrs([
                                    "data-rule-required"=>"true",
                                    "data-msg-required"=>trans('errors.pass')
                                ])
                                
                                ->placeholder( trans('global.login_password') )
                            !!}
                            
                            {!! 
                                Form::password('password_confirmation', trans('global.login_password_confirmation') )
                                ->attrs([
                                    "data-rule-required"=>"true",
                                    "data-msg-required"=>trans('errors.pass_confirm')
                                ])
                                
                                ->placeholder( trans('global.login_password_confirmation') )
                            !!}


                            
                        </div>
                        <div class="row">
                            <div class="col-12 mt-4 text-right">
                                <button type="submit" class="btn btn-success blue-bg btn-block">
                                    {{ trans('global.reset_password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    
                   
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