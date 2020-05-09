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
            <p>{{sprintf('This is a confirmation email, that you have cancelled the following service booking:')}}</p>
            <p>New Schedule for Service Booking is: </p>
            <p>Date: {{ dbDatetimeToDate( $this->bookingOrder->starts_at) }}</p>
            <p>Starts At: {{ dbDatetimeToTime( $this->bookingOrder->starts_at) }}</p>
            <p>Ends At: {{ dbDatetimeToTime( $this->bookingOrder->ends_at ) }}</p>
            <p>Status: Cancelled</p>
            <p style="margin-top: 20px;">Thank you for using {{config('app.name')}}!</p>
        </div>
    </div>
  <div class="footer-email"><p><span>&#169;  </span><span>{{ now()->year }} NDIS All rights reserved</span></p></div>
  </body>
</html>