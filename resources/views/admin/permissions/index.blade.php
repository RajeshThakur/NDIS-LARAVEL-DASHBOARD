@extends('layouts.admin')
@section('content')
{{-- @can('permission_create')
    <div style="margin-bottom: 10px;" class="row mt-button">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.permissions.create") }}">
                {{ trans('global.add') }} {{ trans('global.permission.title_singular') }}
            </a>
        </div>
    </div>
@endcan --}}
<div class="card">
    <div class="card-header mb-4">
        <div class="row">
            <div class="pageTitle">
                <h2>{{ trans('global.user_management_permissions.permission_List') }}</h2>
            </div>
            <div class="icons ml-auto order-last" id="intro_step1"  data-intro="Add to create permissions">
                
                <a class="btn btn-success hint_top rounded" aria-label="Add Participant" href="{{ route("admin.permissions.create") }}">{{ trans('global.user_management_permissions.add_permissions_button') }}</a>
                
            </div>
        </div>
    </div>

    {{-- <div class="Search-Results">
        <h2>Search Results</h2>
    </div> --}}

    <div class="serchbaar mt-3" data-step="3"  data-intro="Add to create permissions" >
        <form action="http://localhost:8000/admin/permissions" method="GET" class="m-0" role="search">
            <div class="input-group">
                {!! 
                    Form::text('q',  '', '' )->placeholder('First Name, Last Name or Email')->attrs(["class"=>"badge-pill bg-white"])
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


    <div class="card-body" data-step="2" data-intro="Chouse any list">
        

        <div class="table-responsive cursor-custom">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>
                            {{ trans('global.permission.fields.title') }}
                        </th>
                        <th class="hide"></th>
                         
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $key => $permission)
                        <tr data-href="{{ route('admin.permissions.edit', $permission->id) }}" data-entry-id="{{ $permission->id }}">
                            <td>
                                <a class="icon" href="{{ route('admin.permissions.edit', $permission->id) }}"> {{ $permission->title ?? '' }}</a>
                            </td>
                            <td class="hide"></td>
                          
                            {{-- <td> --}}
                                {{-- @can('permission_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.permissions.show', $permission->id) }}">
                                        {{ trans('global.view') }}
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan --}}
                               {{-- @can('permission_edit')
                                    <a class="icon" href="{{ route('admin.permissions.edit', $permission->id) }}">
                                        {{-- {{ trans('global.edit') }} --}}
                                        {{-- <i class="fa fa-edit"></i>
                                    </a>
                                @endcan --}}
                                {{-- @can('permission_delete')
                                    <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                         class="icon"
                                        style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button class="fa" type="submit">
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

        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons });

    });
    
</script>

@endsection