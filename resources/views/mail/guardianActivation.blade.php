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
            <h3 style="">{{ sprintf('Hi %s,', $notifiable->name )}}</h3>
            <p>You have been added as Guardian for {{$notifiable->user->getName()}} </p>
            <p>In order to start using your account you need to activate your account and create a password.</p>
            <p><a class="button-msg" href="{{route('activate-advocate', [$notifiable->token])}}">Activate</a></p>
            <p>Thank you for using {{config('app.name')}}!</p>
            <div class="action-link">
              <p>"If you’re having trouble clicking the 'Activate' button, copy and paste the URL below into your web browser: <a href="{{route('activate-advocate', [$notifiable->token])}}">{{route('activate-advocate', [$notifiable->token])}}</a> </p>
            </div>
        </div>
    </div>
  <div class="footer-email"><p><span>&#169;  </span><span>{{ now()->year }} NDIS All rights reserved</span></p></div>
  </body>
</html>