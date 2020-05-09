    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
        <span><i class="fa fa-bullhorn"></i></span>
    <span class="badge badge-warning navbar-badge count-notification">{{$unreadNotificationCount}}</span>
    </a>
    <div class="dropdown-menu small dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header notification-heading">{{$unreadNotificationCount}} Unread Notification</span>
        {{-- <div class="dropdown-divider"></div> --}}

            @foreach ( \Auth::user()->notifications()->orderBy('created_at','desc')->limit(5)->get() as $notification)
                <div class="notifi">
                <a href="{{isset($notification->data['link'])?$notification->data['link']:''}}" class="kt-notification__item ">
                    <div class="kt-notification__item-icon">
                        <i class="fa fa-flag-o" aria-hidden="true"></i>
                    </div>
                    <div class="kt-notification__item-details">
                        <div class="kt-notification__item-title">
                            {{ isset($notification->data['text'])?$notification->data['text']:'' }}
                        </div>
                        <div class="kt-notification__item-time">
                            {{ $notification->created_at->diffForHumans() }}
                        </div>
                    </div>
                    
                </a>
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <span class="close-notification delete-record" data-id="{{ $notification->id }}"><i class="fa fa-times" aria-hidden="true"></i></span>
                {{-- <span class="close-notification delete-record"><i class="fa fa-times" aria-hidden="true"></i></span> --}}
            </div>
            @endforeach
        
        
        
        {{-- <div class="dropdown-divider"></div> --}}
            <a href="{{route('admin.notifications')}}" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>

    @section('scripts')
    @parent
    <script>
        $(function () {
            
            // var count = {{ getTotalMessage() }};
            // $('.count-notification').text(count);
            // $('.notification-heading').text(count+' Notifications');
          
            $(".delete-record").click(function(e){

                var that = $(this);
                var id = $(this).data("id");
                var token = $("meta[name='csrf-token']").attr("content");
                var url = '{{ route("admin.delete.notification", ":id") }}';
                    url = url.replace(':id', id);

                $.ajax(
                {
                    url: url,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function (){
                        that.parent('.notifi').remove();
                        location.reload();
                    }
                });
            });
            
            
        })

    </script>
    @endsection
