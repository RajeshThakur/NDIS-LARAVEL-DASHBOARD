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
            <h3 style="">{{sprintf('Hi %s,', $notifiable->getName() )}}</h3>
            <p>A new comment has been added to the complaint involving service booking.</p>
            <p>Details of the booking are below:</p>
            <p>Service Booking Schedule On:</p>
            <p>Date: {{\Carbon\Carbon::parse( $bookingOrder->starts_at )->format( config('panel.date_input_format') )}}</p>
            <p>Starts At: {{\Carbon\Carbon::parse( $bookingOrder->starts_at )->format( config('panel.time_format') )}}</p>
            <p>Ends at :{{\Carbon\Carbon::parse( $bookingOrder->ends_at )->format( config('panel.time_format') )}}</p>
            <p style="margin-top: 20px;">Thank you for using {{config('app.name')}}!</p>
        </div>
    </div>
  <div class="footer-email"><p><span>&#169;  </span><span>{{ now()->year }} NDIS All rights reserved</span></p></div>
  </body>
</html>