@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('global.registrationGroup.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.registration-groups.store") }}" method="POST" class="validated" enctype="multipart/form-data">
            @csrf
            {!! 
                Form::text('title', trans('global.registrationGroup.fields.title'), old('title', isset($registrationGroup) ? $registrationGroup->title : '') )
                ->id('title')
                ->help(trans('global.registrationGroup.fields.title_helper'))
                ->attrs([ 
                    "required"=>"required", 
                    "data-rule-required"=>"true", 
                    "data-msg-required"=>trans('errors.registration_group.title') 
                ])
            !!}

            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                <label for="status">{{ trans('global.registrationGroup.fields.status') }}*</label>
                <select required="required" data-rule="required" data-msg-required="Please select the status" id="status" name="status" class="form-control">
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
                {!! Form::submit(trans('global.save'))->attrs(["class"=>"btn btn-primary rounded mt-button"]) !!}
            </div>
        </form>
    </div>
</div>
@endsection