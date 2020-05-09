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
            <p>Your Requst for Service Booking Reshedule has been declined!</p>
            <p>Service Booking Schedule remains as: </p>
            <p>Date: {{ dbDatetimeToDate(  $bookingOrder->starts_at ) }}</p>
            <p>Starts At: {{ dbDatetimeToTime( $bookingOrder->starts_at ) }}</p>
            <p>Ends At: {{ dbDatetimeToTime( $bookingOrder->ends_at ) }}</p>
            <p style="margin-top: 20px;">Thank you for using {{config('app.name')}}!</p>
        </div>
    </div>
  <div class="footer-email"><p><span>&#169;  </span><span>{{ now()->year }} NDIS All rights reserved</span></p></div>
  </body>
</html>