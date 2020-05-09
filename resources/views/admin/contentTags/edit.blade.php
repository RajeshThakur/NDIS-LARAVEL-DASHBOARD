@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.contentTag.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.cms.tags.update", [$contentTag->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('cruds.contentTag.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($contentTag) ? $contentTag->name : '') }}" >
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.contentTag.fields.name_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                <label for="slug">{{ trans('cruds.contentTag.fields.slug') }}</label>
                <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug', isset($contentTag) ? $contentTag->slug : '') }}">
                @if($errors->has('slug'))
                    <em class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.contentTag.fields.slug_helper') }}
                </p>
            </div>
            {{-- <div>
                <input class="btn btn-success rounded mt-4" type="submit" value="{{ trans('global.save') }}">
            </div> --}}
            <div>
          
                {!! Form::submit(trans('global.save'), 'primary', 'normal')->attrs(["class"=>"rounded mt-4"]) !!}
              

                {!! Form::button('Delete', 'danger')->attrs(["onclick"=>"return deleteRec();", 'class'=>'rounded ml-40 mt-4']) !!}
            </div>
        </form>
    </div>
</div>
      @can('participant_delete')
                @include('template.deleteItem', [ 'destroyUrl' =>  route("admin.cms.tags.destroy", [$contentTag->id]) ])
        @endcan

@endsection