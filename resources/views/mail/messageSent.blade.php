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
            <h2>Hello</h2>
            <p>You have an unread message.</p>
            <p>{{$data['thread']['subject']}}</p>
            <p><a class="button-msg" href="{{route("admin.messages.show", [$data['thread_id'] ])}}" 
            style=" ">Check the message</a></p>
            <p>Thank you for using {{config('app.name')}}!</p>
            <div class="action-link">
              <p>"If you’re having trouble clicking the 'Check the message' button, copy and paste the URL below into your web browser: <a href="{{route("admin.messages.show", [$data['thread_id'] ])}}">{{route("admin.messages.show", [$data['thread_id'] ])}}</a> </p>
            </div>
        </div> 
    </div>
  <div class="footer-email"><p><span>&#169;  </span><span>{{ now()->year }} NDIS All rights reserved</span></p></div>
  </body>
</html>