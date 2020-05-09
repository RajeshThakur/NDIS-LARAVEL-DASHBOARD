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
                    

                    <form method="POST" class="validated"  action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <h2>{{ trans('global.reset_password_title') }}</h2>

                        <div>
                            <input name="token" value="{{ $token }}" type="hidden">
                            <input type="hidden" name="email" value="{{$email}}"   />


                                    {!! 
                                        Form::password('password', '' )
                                        ->attrs([
                                            "data-rule-required"=>"true",
                                            "data-msg-required"=>trans('errors.pass')
                                        ])
                                        
                                        ->placeholder( trans('global.login_password') )
                                    !!}
                                    
                                    {!! 
                                        Form::password('password_confirmation', '' )
                                        ->attrs([
                                            "data-rule-required"=>"true",
                                            "data-msg-required"=>trans('errors.pass_confirm')
                                        ])
                                        
                                        ->placeholder( trans('global.login_password_confirmation') )
                                    !!}

                        </div>
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-primary btn-block rounded">
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
</div>
@endsection