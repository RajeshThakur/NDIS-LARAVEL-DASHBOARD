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
            <p>You have been assigned to a new task.</p>
            <p>{{$data['name'] }}</p>
            <p><ul>
              @foreach( unserialize($data['description']) as $reason )
                <li>{{$reason}}</li>
              @endforeach
            </ul></p>
            <p>Starts from :{{$startDateTime}}</p>
            <p>Ends at :{{$endDateTime}}</p>
            <p><a class="button-msg" href="{{route('admin.events.show', [$data['id']])}}">Check Event Status</a></p>
            <p>Thank you for using {{config('app.name')}}!</p>
            <div class="action-link">
              <p>"If you’re having trouble clicking the 'Check Event Status' button, copy and paste the URL below into your web browser: <a href="{{route('admin.events.show', [$data['id']])}}">{{route('admin.events.show', [$data['id']])}}</a> </p>
            </div>
        </div>
    </div>
  <div class="footer-email"><p><span>&#169;  </span><span>{{ now()->year }} NDIS All rights reserved</span></p></div>
  </body>
</html>