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
            <h3 style="">{{ sprintf('Hi %s,', $notifiable->getName() )}}</h3>
            <p>{{$message}}</p>
            <p>Details of the booking are below: </p>
            <p>Service Booking Schedule On: </p>
            <p>Date: {{ dbDatetimeToDate(  $bookingOrder->starts_at ) }}</p>
            <p>Starts At: {{ dbDatetimeToTime( $bookingOrder->starts_at ) }}</p>
            <p>Ends At: {{ dbDatetimeToTime( $bookingOrder->ends_at ) }}</p>


            <p>Requested to Rescheduled to: </p>
            <p>Date: {{ dbDatetimeToDate(   $orderMeta['date'] ) }}</p>
            <p>Starts At: {{ dbDatetimeToTime( $orderMeta['start_time'] ) }}</p>
            <p>Ends At: {{ dbDatetimeToTime( $orderMeta['end_time'] ) }}</p>
            <p>You can take appropariate action for the same using {{config('app.name')}} web portal.. </p>
            <p style="margin-top: 20px;">Thank you for using {{config('app.name')}}!</p>
        </div>
    </div>
  <div class="footer-email"><p><span>&#169;  </span><span>{{ now()->year }} NDIS All rights reserved</span></p></div>
  </body>
</html>