@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('global.taskTag.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.task-tags.store") }}" method="POST" class="validated" enctype="multipart/form-data">
            @csrf
            @method('POST')

            {!!
                Form::text('name', trans('global.taskTag.fields.name'), old('name', isset($taskTag) ? $taskTag->name : '') )
                ->id('name')
                ->help(trans('global.taskTag.fields.name_helper'))
                ->size('col-sm-12')
                ->attrs([ 
                    "required"=>"required", 
                    "data-rule-required"=>"true", 
                    "data-msg-required"=>trans('errors.event_management.tags_name') 
                ])
            !!}
            
            {{-- {!! 
                Form::text('color', 'Color', old('color', isset($taskTag->color ) ? $taskTag->color : '') )
                    ->id('color')
                    ->help(trans('global.taskTag.fields.name_helper'))
                    ->attrs(['class'=>'colpicker'])
                    ->size('col-sm-6')
            !!} --}}

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



@section('libScripts')
@parent
    <script src="{{ asset('assets/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
@endsection
@section('libStyles')
@parent
    <link href="{{ asset('assets/colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet" />
@endsection


@section('scripts')
@parent
<script>
    jQuery(document).ready(function(){
        $('.colpicker').colorpicker()
    });
</script>
@stop