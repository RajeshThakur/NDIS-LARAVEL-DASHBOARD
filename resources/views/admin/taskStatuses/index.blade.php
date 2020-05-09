@extends('layouts.admin')
@section('content')
{{-- @can('task_status_create')
    <div style="margin-bottom: 10px;" class="row mt-button">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.events.statuses.create") }}">
                {{ trans('global.add') }} {{ trans('global.taskStatus.title_singular') }}
            </a>
        </div>
    </div>
@endcan --}}
<div class="card">
    {{-- <div class="card-header">
        <div class="row">
            <div class="pageTitle">
                {{ trans('global.taskStatus.title_singular') }} {{ trans('global.list') }}
            </div>
            <div class="icons ml-auto order-last">
                @can('task_status_create')
                    <a class="btn btn-app hint--top" aria-label="{{ trans('global.add') }} {{ trans('global.taskStatus.title_singular') }}" href="{{ route("admin.events.statuses.create") }}">
                        <i class="fa fa-plus"></i>
                    </a>
                @endcan
            </div>
        </div>
    </div> --}}
    <div class="card-header mb-4">
        <div class="row">
             <div class="pageTitle">
               <h2> {{ trans('global.taskStatus.title_singular') }} {{ trans('global.list') }}</h2>
            </div>
            <div class="icons ml-auto order-last" id="intro_step1"  data-intro="Add to create Status List">
                
              <a class="btn btn-success rounded" href="{{ route("admin.events.statuses.create") }}"> 
                {{ trans('global.add') }} {{ trans('global.taskStatus.title_singular') }}
            </a>

            {{-- <a class="btn btn-success rounded" href="javascript:void(0);" onclick="javascript:introJs().start();">  
                {{ trans('global.add') }} {{ trans('global.taskStatus.title_singular') }}
            </a> --}}
            </div>
            {{-- <div class="icons ml-auto order-last">
                <a class="btn btn-success hint--top rounded" aria-label="Add Participant" href="{{ route("admin.events.statuses.create") }}">Add Status</a>
            </div> --}}
        </div>
    </div>

    {{-- <div class="Search-Results">
        <h2>Search Results</h2>
    </div> --}}

    <div class="serchbaar mt-3" data-step="3"  data-intro="Add to create Status List">
        <form action="{{ route('admin.events.statuses.index') }}" method="GET" class="m-0" role="search">
            <div class="input-group">

                {!! 
                    Form::text('q','' , '')->placeholder('First Name, Last Name or Email')->attrs(["class"=>"external-service  badge-pill bg-white"]) 
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
                         <th width="10"></th> 
                        <th>
                            {{ trans('global.taskStatus.fields.name') }}
                        </th>
                        <th></th>
                        {{-- <th>&nbsp;</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($taskStatuses as $key => $taskStatus)
                        <tr data-href="{{ route('admin.events.statuses.edit', $taskStatus->id) }}" data-entry-id="{{ $taskStatus->id }}">
                           <td>

                            </td> 
                            <td>
                               <a class="icon" href="{{ route('admin.events.statuses.edit', $taskStatus->id) }}"> {{ $taskStatus->name ?? '' }}</a>
                            </td>
                            <td></td>
                            {{-- <td> --}}
                                {{-- @can('task_status_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.events.statuses.show', $taskStatus->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan --}}
                                {{-- @can('task_status_edit')
                                    <a class="icon" href="{{ route('admin.events.statuses.edit', $taskStatus->id) }}">
                                        {{-- {{ trans('global.edit') }} --}}
                                        {{-- <i class="fa fa-edit"></i>
                                    </a>
                                @endcan --}} 
                                {{-- @can('task_status_delete')
                                    <form action="{{ route('admin.events.statuses.destroy', $taskStatus->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" 
                                        class="icon"
                                        style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        {{-- <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}"> --}}
                                        {{-- <button class="fa" type="submit">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </form>
                                @endcan --}} 
                            {{-- </td> --}}
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