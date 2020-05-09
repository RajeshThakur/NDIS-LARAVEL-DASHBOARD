@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 new-msg-design">
        <h2>{{ $thread->subject }}</h2>
        @each('admin.messenger.partials.messages', $thread->messages, 'message')

        @include('admin.messenger.partials.form-message')
    </div>
</div>
@stop
