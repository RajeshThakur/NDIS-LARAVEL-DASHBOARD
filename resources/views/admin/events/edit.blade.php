@extends('layouts.admin')
@section('content')

<div class="card">

    <div class="card-header">
        <div class="row">
            <div class="pageTitle">
                <h2>{{ trans('global.task.edit') }}</h2>
            </div>
            <div class="icons ml-auto order-last">

            </div>
        </div>
    </div>

    {{-- <div class="">Learning from past performance ensures your entire company always moves forward with confidence</div> --}}

    <div class="card-body">
        <form action="{{ route("admin.events.update", [$task->id]) }}" method="POST" class="validated" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                {!! Form::text('name', trans('global.task.fields.name')."*", old('name', isset($task) ? $task->name : '') )
                    ->help( trans('global.task.fields.name_helper') )
                    ->size('col-sm-6') 
                    ->id('name')
                    ->attrs([ 
                        "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.event.event_title')
                    ])
                !!}
                
                {!! 
                    Form::date('due_date', trans('global.task.fields.due_date')."*", old('due_date', isset($task) ? $task->due_date : '') )
                    ->id('due_date')
                    ->help(trans('global.task.fields.due_date_helper'))
                    ->size('col-sm-6') 
                    ->attrs([ 
                        "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.event.due_date'), 
                        "data-rule-dateFormat"=>"true",
                        "data-msg-dateFormat"=>trans('errors.event.due_date_formet')
                    ])
                !!}
           
                {!! Form::time('start_time', trans('global.task.fields.start_time'), old('start_time', isset($task) ? $task->start_time : '') )
                    ->size('col-sm-6') 
                    ->id('start_time')
                    ->attrs([ 
                        "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.event.start_time'), 
                    ])
                !!}

                {!! Form::time('end_time', trans('global.task.fields.end_time'), old('end_time', isset($task) ? $task->end_time : '') )
                    ->size('col-sm-6')
                    ->id('end_time')
                    ->attrs([ 
                        "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.event.end_time'), 
                    ]) 
                !!}
           
                {!! Form::location('location', trans('global.task.fields.location')."*", old('location', isset($task) ? $task->location : '') )
                    ->size('col-sm-12') 
                    ->id('location')
                    ->attrs([ 
                        "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.event.location'), 
                    ]) 
                !!}
            
               
                {!! Form::select2('task_assignee_id[]', trans('global.task.fields.invited')."*",$assignables,(isset($assignees) ? $assignees : []))
                    ->id('task_assignee_id')
                    ->attrs([
                        "multiple"=>"multiple", 
                        "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.event.task_assignee_id')
                    ])
                    ->size('col-sm-12')
                !!}

                {!! Form::select('color_id', trans('global.task.fields.color'),$colors,(isset($task->color_id) ? $task->color_id : 0))
                    ->id('color_id')
                    ->size('col-sm-6')
                    ->attrs([
                        "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.event.color')
                    ])
                    
                !!}


                {!! 
                    Form::select2('status_id', trans('global.task.fields.status')."*",$statuses,(isset($task) && $task->status ? $task->status->id : old('status_id')))
                    ->size('col-sm-6')
                    ->id('status_id')
                    ->attrs([
                        "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.event.status')
                    ])
                !!}
    
                {!! Form::textarea('description', trans('global.task.fields.add_note')."*", old('note', isset($task) ? $task->description : '') )
                    ->size('col-sm-12')
                    ->id('description') 
                    ->attrs([
                        "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.event.description')
                    ])
                !!}

            </div>
            
            
            <div>
                {!! Form::submit(trans('global.save'))->attrs(["class"=>"primary rounded"]) !!}
                {!! Form::hidden( 'tags[]', isset($assignedTags[0]) ? $assignedTags[0] : 0 )->id('taskTags') !!}

                {!! Form::button('Delete', 'danger')->attrs(["onclick"=>"return deleteRec();", 'class'=>'rounded ml-30']) !!}
            </div>
        </form>
    </div>
</div>



@can('participant_delete')
    @include('template.deleteItem', [ 'destroyUrl' => route("admin.events.destroy", [$task->id]) ])
@endcan
@endsection


@section('scripts')
@parent
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
@endsection