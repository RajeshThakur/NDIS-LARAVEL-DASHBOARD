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
            <h3 style="color:#222;">{{sprintf('Hi %s,', $notifiable->name )}}</h3>
            <p>you have successfully activated your guardian account on {{config('app.name')}}</p>
            <p>Next you can download our Mobile App for Android/iOS from the links given below and can start using {{config('app.name')}}</p>
            <p style="margin-top: 20px;">Thank you for using {{config('app.name')}}!</p>
            <div class="action-link">
              <a href="{{ url('/') }}">{{ url('/') }}</a>
            </div>
        </div>
    </div>
  <div class="footer-email"><p><span>&#169;  </span><span>{{ now()->year }} NDIS All rights reserved</span></p></div>
  </body>
</html>