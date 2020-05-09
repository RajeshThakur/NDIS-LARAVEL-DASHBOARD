<!doctype html>
<html lang="en">
  <head>
    <title>NDIS</title>
    @include('mail.commonCss')
  </head>
  <body>
    <div class="header-email"><h4>NDIS</h4></div>
    <div class="table-email">
        <div class="table-custom-email">
            <h3>{{sprintf('Hi %s,', $notifiable->getName() )}}</h3>
            <p>Your account has been created. You will need to activate your account to sign in into this account.</p>
            <p><a class="button-msg" href="{{ route('activate', [$user->token]) }}" 
            style=" ">Activate</a></p>
            <p>Thank you for using {{config('app.name')}}!</p>

            <div class="action-link">
              <p>"If you’re having trouble clicking the 'Activate' button, copy and paste the URL below into your web browser: <a href="{{route('activate', [$user->token])}}">{{route('activate', [$user->token])}}</a> </p>
            </div> 
        </div>
    </div>
    <div class="footer-email"><p><span>&#169;  </span><span>{{ now()->year }} NDIS All rights reserved</span></p></div>
  </body>
</html>

