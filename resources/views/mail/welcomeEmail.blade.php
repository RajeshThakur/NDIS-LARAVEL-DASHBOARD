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
            <p>We just noticed that you created a new account. Your account is active now.</p>
            <p><a class="button-msg" href="{{ url('/login') }}" 
            style=" ">Complete your profile</a></p>
            <p>Thank you for using {{config('app.name')}}!</p>
            <div class="action-link">
              <p>"If you’re having trouble clicking the 'Complete your profile' button, copy and paste the URL below into your web browser: <a href="{{url('/login')}}">{{url('/login')}}</a> </p>
            </div>
        </div> 
    </div>
  <div class="footer-email"><p><span>&#169;  </span><span>{{ now()->year }} NDIS All rights reserved</span></p></div>
  </body>
</html>