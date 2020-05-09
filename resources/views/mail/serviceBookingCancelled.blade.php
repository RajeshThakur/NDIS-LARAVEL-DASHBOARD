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
            <p>The Service Booking between {{$participantName}} and {{$workerName}} at {{ dbDatetimeToTime( $bookingOrder->starts_at ) }} on the {{ dbDatetimeToDate( $bookingOrder->starts_at )}} at {{ $bookingOrder->booking->location}} has been cancelled</p>
            <p>{!! $within24 ? 'within 24 hours' : '.' !!}</p>
            <p style="margin-top: 20px;">Thank you for using {{config('app.name')}}!</p>
        </div>
    </div>
  <div class="footer-email"><p><span>&#169;  </span><span>{{ now()->year }} NDIS All rights reserved</span></p></div>
  </body>
</html>