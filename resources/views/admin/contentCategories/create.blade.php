@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.contentCategory.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.cms.categories.store") }}" method="POST" class="validated" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('cruds.contentCategory.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($contentCategory) ? $contentCategory->name : '') }}" required="required" data-rule-required="true" data-msg-required="{{ trans('errors.content_category.category_name')}}">
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.contentCategory.fields.name_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                <label for="slug">{{ trans('cruds.contentCategory.fields.slug') }}</label>
                <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug', isset($contentCategory) ? $contentCategory->slug : '') }}">
                @if($errors->has('slug'))
                    <em class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.contentCategory.fields.slug_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-primary rounded mt-4" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
@endsection