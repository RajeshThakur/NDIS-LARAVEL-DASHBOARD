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
            <h3 style="">{{sprintf('Hi %s,', $data->getName() )}}</h3>
            <p>You have recently signed up with {{config('app.name')}}. We are looking forward to sign the Service Agreement with you.</p>
            <p>We cannot get you started with no service agreement signed. In order to sign the service agreement, please login to our Mobile App and sign the agreement.</p>
            <p>If you haven\'t already downloaded our mobile app, you can download from the links below.</p>
            <p style="margin-top: 20px;">Thank you for using our application!</p>
        </div>
    </div>
  <div class="footer-email"><p><span>&#169;  </span><span>{{ now()->year }} NDIS All rights reserved</span></p></div>
  </body>
</html>