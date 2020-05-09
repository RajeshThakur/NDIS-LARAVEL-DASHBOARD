@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('global.registrationGroup.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.registration-groups.update", [$registrationGroup->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {!! 
                Form::text('title', trans('global.registrationGroup.fields.title'), old('title', isset($registrationGroup) ? $registrationGroup->title : '') )->id('title')->help(trans('global.registrationGroup.fields.title_helper'))
            !!}

            {!! 
                Form::text('item_number', trans('global.registrationGroup.fields.item_number'), old('item_number', isset($registrationGroup) ? $registrationGroup->item_number : '') )->id('item_number')->help(trans('global.registrationGroup.fields.item_number_helper'))
            !!}
            
            {!! 
                Form::text('price_limit', trans('global.registrationGroup.fields.price_limit'), old('price_limit', isset($registrationGroup) ? $registrationGroup->price_limit : '') )->id('price_limit')->help(trans('global.registrationGroup.fields.price_limit_helper'))
            !!}

            <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                <label for="parent_id">{{ trans('global.registrationGroup.fields.parent_id') }}*</label>
                <select id="parent_id" name="parent_id" class="form-control">
                    <option value="0" disabled {{ old('parent_id', 0) === 0 ? 'selected' : '' }}>@lang('global.none')</option>
                    @foreach ($data as $regGroup)
                        <option value="{{ $regGroup->id }}" {{ old('parent_id', $registrationGroup->parent_id) == $regGroup->id ? 'selected' : '' }}>{{ $regGroup->title }}</option>
                    @endforeach
                </select>
                @if($errors->has('parent_id'))
                    <p class="help-block">
                        {{ $errors->first('parent_id') }}
                    </p>
                @endif
            </div>

            
            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                <label for="status">{{ trans('global.registrationGroup.fields.status') }}*</label>
                <select id="status" name="status" class="form-control">
                    <option value="" disabled {{ old('status', null) === null ? 'selected' : '' }}>@lang('global.pleaseSelect')</option>
                    @foreach(App\RegistrationGroup::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $registrationGroup->status) === $key ? 'selected' : '' }}>{{ $label }}</option>
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
                    Form::submit(trans('global.save'))->attrs(["class"=>"btn btn-danger"]) 
                !!}
            </div>
        </form>
    </div>
</div>

@endsection