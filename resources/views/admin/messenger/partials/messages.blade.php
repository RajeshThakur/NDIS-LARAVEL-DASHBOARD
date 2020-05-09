<div class="@if( \Auth::user()->id == $message->user->id ) self @else other  @endif media custom-messanger">
    <div class="@if( \Auth::user()->id == $message->user->id )thread-right @else thread-left  @endif">
        
        <a class="pull-left" href="#">
            {!! getUserAvatar($message->user->id, false, ( \Auth::user()->id == $message->user->id )? 'brown':'orange') !!}    
        </a>
    
        <div class="media-body">
            <h5 class="media-heading">{{ $message->body }}</h5>
            <p>{{ $message->user->getName() }}</p>
            <div class="text-muted">
                <small>Posted {{ $message->created_at->diffForHumans() }}</small>
            </div>
        </div>
     </div>
</div>