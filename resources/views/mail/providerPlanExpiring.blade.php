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
            <h3>{{ sprintf('Hi %s,', $notifiable->getName() ) }}</h3>
            <p>{{$line}}</p>
            <p><a class="button-msg" href="{{ route('admin.users.profile', [$this->data->user_id]) }}" 
            style=" ">Renew NDIS plan now</a></p>
            <p>Thank you for using {{config('app.name')}}!</p>
            <div class="action-link">
              <p>"If you’re having trouble clicking the 'Renew NDIS plan now' button, copy and paste the URL below into your web browser: <a href="{{route('admin.users.profile', [$this->data->user_id])}}">{{route('admin.users.profile', [$this->data->user_id])}}</a> </p>
            </div>
        </div>
    </div>
  <div class="footer-email"><p><span>&#169;  </span><span>{{ now()->year }} NDIS All rights reserved</span></p></div>
  </body>
</html>