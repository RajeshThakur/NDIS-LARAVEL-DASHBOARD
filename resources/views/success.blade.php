@extends('layouts.app')
@section('content')

<div class="front-page">
    <div class="authbox">
        <div class="login-boxes text-center d-flex flex-column">

            <div class="card">
                <!-- <div class="front-screen">
                    <div class="card-body login-card-body">
                    <p>"Your password is changed successfully"</p>
                    <p>"You can now login to NDIS app with new password"</p>
                    <p>"Thanks for using NDIS"</p> 
                    </div>
                </div> -->

                <div class="col-sm-12 m-auto">
                    
                    <img src="/img/check.png" width="150px">
                    <h1> Thank You!</h1>
                   <p class="login-box-msg-text mt-4">The only software that unites NDIS Providers, Support Workers and Participants on the same platform.</p>
                   <div class="col-lg-12 row">
            
            <div class="col-sm-6 d-inline-block">
                    <a class="" href="#" ">                        
                    <img class="text-center" src="/img/store_buton.png" alt="Apple Store"></a>                   
                </div>
                                
                <div class="col-sm-6 d-inline-block">
                    <a href="#" target="_blank">                    
                    <img class="text-center" src="/img/play_button.png" alt="Google Play"></a>               
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
           
        });
    </script>

@endsection