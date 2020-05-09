@extends('layouts.admin')
@section('content')

<div class="card">

    <div class="card-header">
        <div class="row">
            <div class="pageTitle">
                <h2>{{ trans('global.edit') }} {{ trans('global.taskTag.title_singular') }}</h2>
            </div>
            <div class="icons ml-auto order-last">
            </div>
        </div>
    </div>

    <div class="card-body">
        <form action="{{ route("admin.task-tags.update", [$taskTag->id]) }}" method="POST" class="validated" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {!! 
                Form::text('name', trans('global.taskTag.fields.name').'', old('name', isset($taskTag) ? $taskTag->name : '') )
                ->id('name')
                ->help(trans('global.taskTag.fields.name_helper')) 
                ->attrs([ 
                    "required"=>"required", 
                    "data-rule-required"=>"true", 
                    "data-msg-required"=>trans('errors.event_management.tags_name') 
                ])
            !!}

            <div>
          
                {!! Form::submit(trans('global.save'), 'primary', 'normal')->attrs(["class"=>"rounded mt-4"]) !!}
              

                {!! Form::button('Delete', 'danger')->attrs(["onclick"=>"return deleteRec();", 'class'=>'rounded ml-40 mt-4']) !!}
            </div>
        </form>
    </div>
</div>
  {{-- @can('participant_delete')
        @include('template.deleteItem', [ 'destroyUrl' => route('admin.task-tags.destroy', $taskTag->id) ])

@endsection --}}

@can('participant_delete')
                @include('template.deleteItem', [ 'destroyUrl' => route('admin.task-tags.destroy', $taskTag->id) ])
        @endcan

@endsection