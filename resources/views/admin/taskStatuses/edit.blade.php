@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('global.taskStatus.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.events.statuses.update", [$taskStatus->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {!! 
                Form::text('name', trans('global.taskStatus.fields.name'), old('name', isset($taskStatus) ? $taskStatus->name : '') )->id('name')->help(trans('global.taskStatus.fields.name_helper')) 
            !!}

            <div>


                {!! Form::submit(trans('global.save'), 'primary', 'normal')->attrs(["class"=>"rounded"]) !!}
                
                {!! Form::button('Delete', 'danger')->attrs(["onclick"=>"return deleteRec();", 'class'=>'rounded ml-40']) !!}

            {{-- {!! 
                Form::submit(trans('global.save'))->attrs(["class"=>"rounded"]) 
            !!} --}}

            </div>
        </form>
        
    </div>
</div>
 @can('participant_delete')
                @include('template.deleteItem', [ 'destroyUrl' =>  route("admin.events.statuses.destroy", [$taskStatus->id]) ])
        @endcan

@endsection