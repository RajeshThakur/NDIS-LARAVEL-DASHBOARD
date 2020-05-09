@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('global.permission.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.permissions.store") }}" method="POST" class="validated" enctype="multipart/form-data">
            @csrf

            {!! 
                Form::text('title', trans('global.permission.fields.title'), old('title', isset($permission) ? $permission->title : '') )
                ->id('title')
                ->help(trans('global.permission.fields.title_helper'))
                ->attrs([ 
                    "required"=>"required", 
                    "data-rule-required"=>"true", 
                    "data-msg-required"=>trans('errors.user_management.permission_title') 
                ]) 
            !!}

            <div>
                {!! Form::submit(trans('global.save'))->attrs(["class"=>"btn btn-primary rounded mt-button"]) !!}
            </div>
        </form>
    </div>
</div>
@endsection