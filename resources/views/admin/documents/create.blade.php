@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('documents.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.documents.upload") }}" method="POST" aria-label="{{ __('Upload') }}" enctype="multipart/form-data">
            @csrf

            {!! 
                Form::text('title', trans('documents.fields.title'), old('title', isset($registrationGroup) ? $registrationGroup->title : '') )->id('title')->help(trans('documents.fields.title_helper'))
            !!}

            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                <label for="status">{{ trans('documents.fields.status') }}*</label>
                <select id="status" name="status" class="form-control">
                    <option value="" disabled {{ old('status', null) === null ? 'selected' : '' }}>@lang('global.pleaseSelect')</option>
                    @foreach(App\RegistrationGroup::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', null) === (string)$key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <p class="help-block">
                        {{ $errors->first('status') }}
                    </p>
                @endif
            </div>
            <div>
                {!! 
                    Form::submit(trans('global.save'))->attrs(["class"=>"btn btn-success"]) 
                !!}
            </div>
        </form>
    </div>
</div>
@endsection