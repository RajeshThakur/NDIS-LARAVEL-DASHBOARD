
    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
       
        <?php 
            $count = Auth::user()->newThreadsCount();
            // $newMessages = Auth::user()->threadsWithNewMessages();
            $newMessages = newMessages(3);
        ?>
        @if($count > 0)
            <i class="fa fa-envelope-o" aria-hidden="true"></i>               
            <span class="badge badge-danger navbar-badge">{{ $count }}</span>
        @else
            <i class="fa fa-envelope-open-o"></i>
            <span class="badge badge-danger navbar-badge"></span>
            <span class="badge badge-warning navbar-badge count-notification message">0</span>
        @endif
        
    </a>  
    <div class="dropdown-menu small dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header notification-heading">{{$count}} {{trans('global.messaging.unread_messages')}}</span>
        @foreach($newMessages as $key => $message)
            <a href="{{  route('admin.messages.show', $message['id']) }}" class="dropdown-item">
                <!-- Message Start -->
                <div class="media">
                    <div class="media-body">
                    <h3 class="dropdown-item-title">{{ $message['subject'] }}
                        <span class="float-right text-sm text-danger"><i class="fa fa-share"></i></span>
                    </h3>
                    <p class="text-sm">{{ $message['name'] }}</p>
                    <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> {{ $message['time'] }} </p>
                    </div>
                </div>
            <!-- Message End -->
        </a>
        @endforeach
       
        <a href="{{ route('admin.messages.index') }}" class="dropdown-item dropdown-footer">See All Messages</a>
    </div> 
