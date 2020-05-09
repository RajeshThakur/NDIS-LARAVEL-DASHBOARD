@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header mb-4">
        <div class="row">
            <div class="pageTitle">
                <h2>{{ trans('global.task.title_singular') ." ". trans('global.list') }}</h2>
            </div>
            <div class="icons ml-auto order-last" id="intro_step1"  data-intro="Add to create Event List">
                @can('task_create')
                    <a class="btn btn-success hint--top rounded" aria-label="{{ trans('global.addtask') ." " . trans('global.task.title_singular')  }}" href="{{ route("admin.events.create") }}">{{ trans('global.addtask') ." " . trans('global.task.title_singular')  }}</a>
                @endcan
            </div>
        </div>
    </div>

    <div class="serchbaar mt-3 mb-4" data-step="3"  data-intro="Add to create Event List">
         <form action="{{ route("admin.events.index") }}" method="GET" class="m-0" role="search">
            <div class="input-group">
                 {!! 
                    Form::text('s',null, $searchString)->placeholder('Search events by title or description ')->attrs(["class"=>"external-service  badge-pill bg-white"])->hideLabel()
                !!}
               <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"><img class="search" src="{{url('img/search.png')}}" alt="NDIS" /></span>
                    </button>
                </span>
            </div>
        </form>
    </div>

   
    <div class="">       
        @if( isset($tasks->search))        
            {!! $tasks->search['message'] !!}
        @endif
    </div> 

     <div class="card-body" data-step="2" data-intro="Chouse any list">
        <div class="table-responsive cursor-custom">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                 
                        <th>
                            {{ trans('global.task.fields.name') }}
                        </th>
                        <th>
                            {{ trans('global.task.fields.assigned_to') }}
                        </th>
                        <th>
                            {{ trans('global.task.fields.start_time') }}
                        </th>
                       {{-- <th>
                            {{ trans('global.task.fields.end_time') }}
                        </th> --}}
                        <th>
                            {{ trans('global.task.fields.status') }}
                        </th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $key => $task)
                        <tr data-href="{{ route('admin.events.edit', $task->id) }}" data-entry-id="{{ $task->id }}">
                    
                            <td width="50%">
                                 <a class="" href="{{ route('admin.events.edit', $task->id) }}">{{ $task->name ?? '' }}</a>
                            </td>
                            <td width="15%">
                                @foreach($task->assignees as $key => $user)
                                    <span class="badge badge-info" id="user_{{$user->id}}">{{ $user->first_name . ' ' . $user->last_name  }}</span>
                                @endforeach
                            </td>
                            <td width="20%">
                                {{ dbToDatetime(\Carbon\Carbon::create( $task->due_date.' '.$task->start_time ) ) }}
                            </td>
                           {{--  <td>
                                {{ $task->due_date.' '.$task->end_time }}
                            </td> --}}
                            <td width="15%">
                                {{ $task->status->name ?? '' }}
                           </td>
                        
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
        
        $('*[data-href]').on("click",function(){
            window.location = $(this).data('href');
            return false;
        });
        
        $("td > a").on("click",function(e){
            e.stopPropagation();
        });

    })



</script>
@endsection