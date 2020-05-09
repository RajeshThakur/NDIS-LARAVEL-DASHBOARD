@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('global.user.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.users.store") }}" method="POST" class="validated" enctype="multipart/form-data">
            @csrf

            {!! 
                Form::text('name', trans('global.user.fields.name'), old('name', isset($user) ? $user->name : ''))
                ->id('name')
                ->help(trans('global.user.fields.name_helper'))
                ->attrs([ 
                    "required"=>"required", 
                    "data-rule-required"=>"true", 
                    "data-msg-required"=>trans('errors.user_management.user_name') 
                ])
            !!}

            {!! 
                Form::text('email', trans('global.user.fields.email'), old('email', isset($user) ? $user->email : ''))
                ->id('email')
                ->help(trans('global.user.fields.email_helper'))
                ->attrs([ 
                    "required"=>"required", 
                    "data-rule-required"=>"true", 
                    "data-msg-required"=>trans('errors.user_management.user_email') 
                ])
            !!}

            {!! 
                Form::text('password', trans('global.user.fields.password') )
                ->id('password')
                ->help(trans('global.user.fields.password_helper'))
                ->attrs([ 
                    "required"=>"required", 
                    "data-rule-required"=>"true", 
                    "data-msg-required"=>trans('errors.user_management.user_password') 
                ])
            !!}
            

            {!! 
                Form::select('size2', 'Size2',  array('L' => 'Large', 'S' => 'Small'), 'S' )->size('col-sm-12 ') 
            !!}

            <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }}">
                <label for="roles">{{ trans('global.user.fields.roles') }}
                    <span class="btn btn-info btn-xs select-all">Select all</span>
                    <span class="btn btn-info btn-xs deselect-all">Deselect all</span></label>
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

            <div>
                <input class="btn btn-primary rounded mt-button" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
@endsection