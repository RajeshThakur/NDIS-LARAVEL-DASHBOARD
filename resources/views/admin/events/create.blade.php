@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{-- {{ trans('global.create') }} {{ trans('global.task.title_singular') }} --}}
        {{ trans('global.task.create') }}
    </div>

        {{-- <div class="">Learning from past performance ensures your entire company always moves forward with confidence</div> --}}

        <div class="card-body">
            <form action="{{ route("admin.events.store") }}" method="POST" class="validated" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="row">

                    {!! Form::text('name', trans('global.task.fields.name')."", old('name', isset($task) ? $task->name : '') )
                    ->id('name')
                    ->attrs([ 
                        "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.event.event_title'),
                    ])
                    ->help( trans('global.task.fields.name_helper') )
                    ->size('col-sm-6') !!}
                    
                    {!! 
                        Form::date('due_date', trans('global.task.fields.due_date')."", old('due_date', isset($task) ? $task->due_date : '') )
                        ->id('due_date')
                        ->attrs([ 
                            "required"=>"required", 
                            "data-rule-required"=>"true", 
                            "data-msg-required"=>trans('errors.event.due_date'), 
                            "data-rule-dateFormat"=>"true",
                            "data-msg-dateFormat"=>trans('errors.event.due_date_formet')
                        ])
                        ->help(trans('global.task.fields.due_date_helper'))
                        ->size('col-sm-6 pr-0') 
                    !!}

                    {!! Form::time('start_time', trans('global.task.fields.start_time'), old('start_time', isset($task) ? $task->start_time : '') )
                        ->id('start_time')
                        ->attrs([ 
                            "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.event.start_time'), 
                        ])
                        ->size('col-sm-6') !!}
                    

                    {!! Form::time('end_time', trans('global.task.fields.end_time'), old('end_time', isset($task) ? $task->end_time : '') )
                        ->id('end_time')
                        ->attrs([ 
                            "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.event.end_time'), 
                        ])
                        ->size('col-sm-6 pr-0') !!}

               

                    {!! Form::location('location', trans('global.task.fields.location')."", old('location', isset($task) ? $task->location : '') )
                        ->id('location')
                        ->attrs([ 
                            "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.event.location'),
                        ])
                        ->size('col-sm-12') 
                    !!}

                    {!! Form::select2('task_assignee_id[]', trans('global.task.fields.invited')."*", $assignables, [] )
                        ->id('task_assignee_id')
                        ->attrs([
                            "multiple"=>"multiple", 
                            "required"=>"required", 
                            "data-rule-required"=>"true", 
                            "data-msg-required"=>trans('errors.event.task_assignee_id')
                        ])
                        ->size('col-sm-12')
                    !!}

                    {!! Form::select('color_id', trans('global.task.fields.color'),$colors)
                        ->id('color_id')
                    ->size('col-sm-6')
                    ->attrs([
                        "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.event.color')
                    ])
                    !!}


                    {!! 
                        Form::select2('status_id', trans('global.task.fields.status')."",$statuses)
                        ->id('status_id')
                        ->attrs([ 
                            "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.event.status')
                        ])
                        ->size('col-sm-6 pr-0')
                    !!}

                    {!! Form::textarea('description', trans('global.task.fields.add_note')."", old('note', isset($task) ? $task->note : '') )
                    ->id('description')
                    ->attrs([ 
                        "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.event.description')
                    ])
                    ->size('col-sm-12')
                    ->placeholder('Start Writing !')
                    !!}
                <div class="form-group col-sm-12">
                    {!! Form::submit(trans('global.save'))->attrs(["class"=>"primary rounded mt-button"]) !!}
                </div>

                </div>


                {!! Form::hidden( 'tags[]', $tag->id )->id('taskTags') !!}

            </form>
        </div>
        
    @if( empty($assignables) )

        <script>
            window.onload = function(e) {
                ndis.displayMsg( "error", "No Support Worker, External Service Provider or Participant is availbale under you.Please add them to create and assign an event!");
            };
        </script>

    @endif

    
</div>
@endsection

@section('scripts')
<script>

$(document).ready(function(){

    $(".colors").select2({
        templateResult: function (color) {
	        if (!color.id) {
                return color.text;
            }
            console.log(color.text);
            var $color = $('<span><span class="'+color.element.text.toLowerCase()+'-bg color-patch"></span> ' + color.text+'</span>');
            return $color;
	    },
        templateSelection: function (color) {
	        if (color.id.length > 0 ) {
	            return '<span class="'+color.element.text.toLowerCase()+'-bg color-patch"></span> '+color.text;
	        } else {
	            return color.text;
	        }
	    },
        escapeMarkup: function (m) {
            return m;
        },
        selectOnClose: true
    });
})
</script>
@stop