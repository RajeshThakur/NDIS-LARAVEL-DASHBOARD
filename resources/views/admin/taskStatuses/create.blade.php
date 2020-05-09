@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('global.taskStatus.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.events.statuses.store") }}" method="POST" enctype="multipart/form-data">
            @csrf

            {!! 
                Form::text('name', trans('global.taskStatus.fields.name'), old('name', isset($taskStatus) ? $taskStatus->name : '') )->id('name')->help(trans('global.taskStatus.fields.name_helper')) 
            !!}

            <div>

            {{-- {!! 
                Form::submit(trans('global.save'))->attrs(["class"=>"rounded mt-button"]) 
            !!} --}}

             {!! Form::submit(trans('global.save'))->attrs(["class"=>"btn btn-primary rounded mt-4"]) !!}
            
            </div>
        </form>
    </div>
</div>
@endsection