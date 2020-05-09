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

                    <h2>{{ trans('global.password_set') }}</h2>

                    <p>{{trans('msg.password_created', ['appstorelink'=>config('ndis.applink.ios'), 'playstorelink'=>config('ndis.applink.android')])}}</p>
                </div>

            </div>
      </div>
    </div>
</div>
@endsection