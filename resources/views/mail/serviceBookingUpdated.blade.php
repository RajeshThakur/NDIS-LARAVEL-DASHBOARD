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
            <h3 style="">{{ sprintf('Hi %s %s,', $user->first_name, $user->last_name ) }}</h3>
            <p>{{sprintf('A service booking, involving you has been updated!')}}</p>
            <p>Details for the Service Booking is as followed: </p>
            <p>{{sprintf('Participant: %s',$notifiable->getName())}}</p>
            <p>{{$worker}}</p>
            <p>{{ sprintf('Starts At: %s',$booking->starts_at) }}</p>
            <p>{{ sprintf('Ends At: %s',$this->booking->ends_at) }}</p>
            <p>More details can be found under the Mobile App!</p>
            <p style="margin-top: 20px;">Thank you for using {{config('app.name')}}!</p>
        </div>
    </div>
  <div class="footer-email"><p><span>&#169;  </span><span>{{ now()->year }} NDIS All rights reserved</span></p></div>
  </body>
</html>