@extends('layouts.admin')
@section('content')
{{-- @can('role_create')
    <div style="margin-bottom: 10px;" class="row mt-button">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.roles.create") }}">
                {{ trans('global.add') }} {{ trans('global.role.title_singular') }}
            </a>
        </div>
    </div>
@endcan --}}
<div class="card">
    {{-- <div class="card-header">
        {{ trans('global.role.title_singular') }} {{ trans('global.list') }}
    </div> --}}
    <div class="card-header mb-4">
        <div class="row">
            <div class="pageTitle">
                <h2>{{ trans('global.user_management_role.role_List') }}</h2>
            </div>
            <div class="icons ml-auto order-last" id="intro_step1"  data-intro="Add to Create Role">
                <a class="btn btn-success hint--top rounded" aria-label="Add Participant" href="{{ route("admin.roles.create") }}">{{ trans('global.user_management_role.add_role_button') }}</a>
            </div>
        </div>
    </div>


    {{-- <div class="serchbaar mt-3">
     <div class="serchbaar">

        <form action="http://localhost:8000/admin/roles" method="GET" class="m-0" role="search">
            <div class="input-group">
                <input type="text" class="form-control external-service  badge-pill bg-white" name="q" value="" placeholder="First Name, Last Name or Email">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"><i class="fa fa-search"></i></span>
                    </button>
                </span>
            </div>
        </form>
    </div> 
    </div> --}}
     {{-- <div class="Search-Results">
        <h2>Search Results</h2>
    </div> --}}

     <div class="serchbaar mt-3" data-step="3"  data-intro="Add to Create Role" >
        <form action="http://localhost:8000/admin/roles" method="GET" class="m-0" role="search">

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

    <div class="card-body mt-3" data-step="2" data-intro="Chouse any list">
        <div class="table-responsive cursor-custom">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('global.role.fields.title') }}
                        </th>
                        <th>
                            {{ trans('global.role.fields.permissions') }}
                        </th>
                        {{-- <th>
                            &nbsp;
                        </th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $key => $role)
                        <tr data-href="{{ route('admin.roles.edit', $role->id) }}" data-entry-id="{{ $role->id }}">
                            <td>

                            </td>
                            <td>
                                 <a class="icon" href="{{ route('admin.roles.edit', $role->id) }}">  {{ $role->title ?? '' }}</a>
                            </td>
                            <td>
                                @foreach($role->permissions as $key => $item)
                                    <span class="badge badge-info">{{ $item->title }}</span>
                                @endforeach
                            </td>
                            {{-- <td> --}}
                                {{-- @can('role_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.roles.show', $role->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan  --}}
                               {{-- @can('role_edit')
                                    <a class="icon" href="{{ route('admin.roles.edit', $role->id) }}"> --}}
                                       {{-- {{ trans('global.edit') }} --}}
                                        {{-- <i class="fa fa-edit"></i>
                                    </a>
                                @endcan  --}}
                                {{-- @can('role_delete')
                                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" 
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