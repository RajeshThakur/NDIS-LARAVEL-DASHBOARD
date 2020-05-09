<?php 
        $class = $thread->isUnread(Auth::id()) ? 'alert-info' : ''; 
        in_array($thread->id, $unread->toArray()) ? $isUnread = 'unread-message' : $isUnread = '' ;
?>

{{-- <div class="media alert {{ $class }}">
    <h4 class="media-heading">
        <a href="{{ route('messages.show', $thread->id) }}">{{ $thread->subject }}</a>
        ({{ $thread->userUnreadMessagesCount(Auth::id()) }} unread)</h4>
    <p>
        {{ $thread->latestMessage->body }}
    </p>
    <p>
        <small><strong>Creator:</strong> {{ $thread->creator()->name }}</small>
    </p>
    <p>
        <small><strong>Participants:</strong> {{ $thread->participantsString(Auth::id()) }}</small>
    </p>
</div> --}}
                     
<tr class="{{$isUnread}}">
        <td>
            {{$count}}
        </td>
        <td>
            <a href="{{ route('admin.messages.show', $thread->id) }}"> {{$thread->subject}}</a>
                       
        </td>
        <td>
            {{ $thread->participantsString(Auth::id()) }}
        </td>
        <td class="text-right">
            {{ dbToDatetime($thread->created_at) }}
        </td>
                              

    </tr>    

