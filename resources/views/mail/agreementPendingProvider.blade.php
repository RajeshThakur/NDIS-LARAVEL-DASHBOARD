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
            <p>There are pending agreements that needs your signatures.</p>
            <p>In order to get these participants/support workers started, we need these agreements finished and signed up!</p>
            <p>You can sign this form by looging into the Provider Portal.</p>
            <p><a class="button-msg" href="{{route('admin.events.show', [$data['id']])}}">Sign Agreement Now</a></p>
            <p>Thank you for using our application!</p>
            <div class="action-link">
              <p>"If you’re having trouble clicking the 'Sign Agreement Now' button, copy and paste the URL below into your web browser: <a href="{{route('admin.events.show', [$data['id']])}}">{{route('admin.events.show', [$data['id']])}}</a> </p>
            </div>
        </div>
    </div>
  <div class="footer-email"><p><span>&#169;  </span><span>{{ now()->year }} NDIS All rights reserved</span></p></div>
  </body>
</html>