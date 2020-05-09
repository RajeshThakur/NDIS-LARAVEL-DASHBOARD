@extends('layouts.admin')
@section('content')
{{-- @can('task_tag_create')
    <div style="margin-bottom: 10px;" class="row mt-button">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.task-tags.create") }}">
                {{ trans('global.add') }} {{ trans('global.taskTag.title_singular') }}
            </a>
        </div>
    </div>
@endcan --}}
<div class="card">
    <div class="card-header mb-4">
        <div class="row">
            <div class="pageTitle">
                <h2>{{ trans('global.Event_management_tags.tags_List') }}</h2>
            </div>
            <div class="icons ml-auto order-last" id="intro_step1"  data-intro="Add to create Tag List">
                <!-- <a class="btn btn-success hint--top rounded" aria-label="Add Participant" href="{{ route("admin.task-tags.create") }}">Add Tag</a> -->
                <a class="btn btn-success hint--top rounded" aria-label="Add Participant" href="javascript:void(0);" onclick="javascript:introJs().start();">{{ trans('global.Event_management_tags.tags_user_button') }}</a>
            </div>
        </div>
    </div>
     {{-- <div class="Search-Results">
        <h2>Search Results</h2>
    </div> --}}

   <div class="serchbaar mt-3" data-step="3"  data-intro="Add to create Tag List">
        <form action="http://localhost:8000/admin/taskTags" method="GET" class="m-0" role="search">
            <div class="input-group">
                {!! 

                    // Form::text('q','' , 'First Name, Last Name or Email' )->attrs(['class'=>'external-service  badge-pill bg-white']);

                    Form::text('q' )
                    ->placeholder('First Name, Last Name or Email..')
                    ->attrs(['class'=>'external-service  badge-pill bg-white']);

                !!}
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"><img class="search" src="{{url('img/search.png')}}" alt="NDIS" /></span>
                    </button>
                </span>
            </div>
        </form>
    </div>

    <div class="card-body" data-step="2" data-intro="Chouse any list">
        <div class="table-responsive cursor-custom">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10"> 

                        </th> 
                        <th>
                            {{ trans('global.taskTag.fields.name') }}
                        </th>
                        <th>
                            
                        </th> 
                    </tr>
                </thead>
                <tbody>
                    @foreach($taskTags as $key => $taskTag)
                        <tr data-href="{{ route('admin.task-tags.edit', $taskTag->id) }}" data-entry-id="{{ $taskTag->id }}">
                            <td>

                            </td> 
                            <td>
                                {{-- {{ $taskTag->name ?? '' }} --}}
                                 <a class="icon" href="{{ route('admin.task-tags.edit', $taskTag->id) }}">  {{ $taskTag->name ?? '' }}</a>
                            </td>
                            <td></td>
                            {{-- <td>
                                @can('task_tag_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.task-tags.show', $taskTag->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan
                                @can('task_tag_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.task-tags.edit', $taskTag->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @can('task_tag_delete')
                                    <form action="{{ route('admin.task-tags.destroy', $taskTag->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        {!! 
                                            Form::submit(trans('global.delete'))->attrs(["class"=>"btn-danger"]) 
                                        !!}
                                    </form>
                                @endcan
                            </td> --}}

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