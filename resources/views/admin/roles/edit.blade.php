@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('global.role.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.roles.update", [$role->id]) }}"  method="POST" class="validated" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {!! 
                Form::text('title', trans('global.role.fields.title'), old('title', isset($role) ? $role->title : ''))
                ->id('title')
                ->help(trans('global.role.fields.title_helper'))
                ->attrs([ 
                    "required"=>"required", 
                    "data-rule-required"=>"true", 
                    "data-msg-required"=>trans('errors.user_management.roles_title') 
                ])
            !!}

            <div class="form-group {{ $errors->has('permissions') ? 'has-error' : '' }}">
                <label for="permissions">{{ trans('global.role.fields.permissions') }}*
                    <span class="btn btn-info btn-xs select-all">Select all</span>
                    <span class="btn btn-info btn-xs deselect-all">Deselect all</span></label>
                    <select required="required" data-rule="required" data-msg-required="Registration group selection required" name="permissions[]" id="permissions" class="form-control select2" multiple="multiple">	
                            @foreach($permissions as $id => $permissions)	
                               <option value="{{ $id }}" {{ (in_array($id, old('permissions', [])) || isset($role) && $role->permissions->contains($id)) ? 'selected' : '' }}>{{ $permissions }}</option>	
                           @endforeach	
                       </select>	
                       @if($errors->has('permissions'))	
                           <p class="help-block">	
                               {{ $errors->first('permissions') }}	
                           </p>	
                       @endif
                <p class="helper-block">
                    {{ trans('global.role.fields.permissions_helper') }}
                </p>
            </div>
            <div class="mt-40">
                {!! Form::submit(trans('global.save'))->attrs(["class"=>"btn btn-primary rounded"]) !!}
            </div>
        </form>
    </div>
</div>

@endsection