@extends('layouts.app')
@section('content')

<div class="front-page">
    <div class="authbox">
        <div class="login-boxes text-center d-flex flex-column">

            <div class="card">
                <div class="front-screen">
                    <div class="card-body login-card-body">
                        <p><a href="{{ route('login') }}" title="{{ trans('global.site_title') }}"><img src="/img/logo_2.png" style="width: 60%;" alt="NDIS Central"></a></p>
                        <p class="login-box-msg font-weight-bold">{{ trans('global.pages.login.headline') }}</p>
                        <p class="login-box-msg-text">{{ trans('global.pages.login.subHeading') }}</span></p>
                        @if(\Session::has('message'))
                            <p class="alert alert-info">
                                {{ \Session::get('message') }}
                            </p>
                        @endif
                    <div class="front-button">
                        <p><a href="{{ route('login') }}" title="{{ trans('global.signIn') }}"><button class="sign-in btn btn-primary rounded">{{ trans('global.signIn') }}</button></a></p>
                        <p><a  href="{{ route('register') }}"><button class="sign-up btn btn-success rounded">{{ trans('global.signUp') }}</button></a></p>
                    </div>
                    </div>
                </div>

                <!-- /.login-card-body -->
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