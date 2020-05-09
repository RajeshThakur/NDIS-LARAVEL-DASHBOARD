@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('global.user.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.users.update", [$user->id]) }}" method="POST" class="validated" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {!! Form::text('first_name', trans('global.user.fields.first_name').'', old('first_name', isset($user) ? $user->first_name : ''))
                ->help(trans('global.user.fields.first_name_helper')) 
                ->id('first_name')
                ->attrs([ 
                    "required"=>"required", 
                    "data-rule-required"=>"true", 
                    "data-msg-required"=>trans('errors.user_management.user_first_name') 
                ])
            !!}
            
            {!! Form::text('last_name', trans('global.user.fields.last_name').'', old('last_name', isset($user) ? $user->last_name : ''))
                ->help(trans('global.user.fields.last_name_helper')) 
                ->id('last_name')
                ->attrs([ 
                    "required"=>"required", 
                    "data-rule-required"=>"true", 
                    "data-msg-required"=>trans('errors.user_management.user_last_name') 
                ])
            !!}
            
            {!! Form::email('email', trans('global.user.fields.email').'', old('email', isset($user) ? $user->email : ''))
                ->help(trans('global.user.fields.email_helper')) 
                ->id('email')
                ->attrs([ 
                    "required"=>"required", 
                    "data-rule-required"=>"true", 
                    "data-msg-required"=>trans('errors.user_management.user_email') 
                ])
            !!}

            {!! Form::password('password', trans('global.user.fields.password').'', '' )
                ->help(trans('global.user.fields.password_helper')) 
                ->id('email')
                ->attrs([ 
                    "required"=>"required", 
                    "data-rule-required"=>"true", 
                    "data-msg-required"=>trans('errors.user_management.user_password') 
                ])
            !!}

            <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }}">
                <label for="roles">{{ trans('global.user.fields.roles') }}
                    <span class="btn btn-info btn-xs select-all">Select all</span>
                    <span class="btn btn-info btn-xs deselect-all">Deselect all</span>
                </label>
                <select required="required" data-rule="required" data-msg-required="Please select the Roles" name="roles[]" id="roles" class="form-control select2" multiple="multiple">
                    @foreach($roles as $id => $roles)
                        <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
                    @endforeach
                </select>
                @if($errors->has('roles'))
                    <p class="help-block">
                        {{ $errors->first('roles') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('global.user.fields.roles_helper') }}
                </p>
            </div>
            <div class="mt-40">
                {!! Form::submit(trans('global.save'), 'primary', 'normal')->attrs(["class"=>"rounded"]) !!}
            </div>
        </form>
    </div>
</div>

@endsection