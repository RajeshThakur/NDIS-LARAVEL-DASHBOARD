@if ($errors->any())
    {!! implode('', $errors->all('<div><p class="help-block">:message</p></div>')) !!}
@endif