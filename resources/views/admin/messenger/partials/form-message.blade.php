<div class="media custom-messanger reply-msg">
    <h5>Reply to : {{$replyTo['first_name']}}  {{$replyTo['last_name']}} | <span>{{$replyTo['email']}}</span></h5>
</div>
<form action="{{ route('admin.messages.update', $thread->id) }}" class="validated" method="post">

    {{ method_field('put') }}

    {{ csrf_field() }}
        
    <!-- Message Form Input -->
    {!! 
        Form::textarea('message', '', old('message') )
        ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Message field is required" ])
    !!}
{{-- 
    @if($users->count() > 0)
        <div class="checkbox">
            @foreach($users as $user)
                <label title="{{ $user->name }}">
                    <input type="checkbox" name="recipients[]" value="{{ $user->id }}">{{ $user->name }}
                </label>
            @endforeach
        </div>
    @endif --}}

    <!-- Submit Form Input -->
    <div class="form-group">
        <button type="submit" class="btn btn-primary rounded">Submit</button>
    </div>
</form>