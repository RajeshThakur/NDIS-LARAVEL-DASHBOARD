@extends('layouts.admin')
@section('content')
{{-- @can('user_create')
    <div style="margin-bottom: 10px;" class="row mt-button">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.users.create") }}">
                {{ trans('global.add') }} {{ trans('global.user.title_singular') }}
            </a>
        </div>
    </div>
@endcan --}}
<div class="card">
    {{-- <div class="card-header">
        {{ trans('global.user.title_singular') }} {{ trans('global.list') }}
    </div> --}}
    <div class="card-header mb-4">
        <div class="row">
            <div class="pageTitle">
                <h2>{{ trans('global.user_management_user.user_List') }}</h2>
            </div>
            <div class="icons ml-auto order-last" id="intro_step1"  data-intro="Add to Create User List">
                <a class="btn btn-success hint--top rounded" aria-label="Add Participant" href="{{ route("admin.users.create") }}">{{ trans('global.user_management_user.add_user_button') }}</a>
            </div>
        </div>
    </div>

    {{-- <div class="Search-Results">
        <h2>Search Results</h2>
    </div> --}}

    <div class="serchbaar mt-3" data-step="3"  data-intro="Add to Create User List">
        <form action="http://localhost:8000/admin/users" method="GET" class="m-0" role="search">
            <div class="input-group">
                {!! 
                    Form::text('q','' , '')->placeholder('First Name, Last Name or Email')->attrs(["class"=>"external-service  badge-pill bg-white"])->help(trans('global.user.fields.name_helper'))
                !!}
               <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"><img class="search" src="{{url('img/search.png')}}" alt="NDIS" /></span>
                    </button>
                </span>
            </div>
        </form>
    </div>

    <div class="card-body mt-3 " data-step="2" data-intro="Chouse any list">
        <div class="table-responsive cursor-custom">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('global.user.fields.name') }}
                        </th>
                        <th>
                            {{ trans('global.user.fields.email') }}
                        </th>
                        <th>
                            {{ trans('global.user.fields.email_verified_at') }}
                        </th>
                        <th>
                            {{ trans('global.user.fields.roles') }}
                        </th>
                        {{-- <th>
                            &nbsp;
                        </th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                        <tr data-href="{{ route('admin.users.edit', $user->id) }}" data-entry-id="{{ $user->id }}">
                            <td>

                            </td>
                            <td>
                                 <a class="icon" href="{{ route('admin.users.edit', $user->id) }}">{{ $user->first_name ?? '' }} {{ $user->last_name ?? '' }}</a>
                            </td>
                            <td>
                                 <a class="icon" href="{{ route('admin.users.edit', $user->id) }}">{{ $user->email ?? '' }}</a>
                            </td>
                            <td>
                                 <a class="icon" href="{{ route('admin.users.edit', $user->id) }}">{{ $user->email_verified_at ?? '' }}</a>
                            </td>
                            <td>
                                @foreach($user->roles as $key => $item)
                                    <span class="badge badge-info">{{ $item->title }}</span>
                                @endforeach
                            </td>
                            {{-- <td> --}}
                                {{-- @can('user_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.users.show', $user->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan --}}
                                {{-- @can('user_edit')
                                    <a class="icon" href="{{ route('admin.users.edit', $user->id) }}">
                                        {{-- {{ trans('global.edit') }} --}}
                                        {{-- <i class="fa fa-edit"></i>
                                    </a>
                                @endcan
                                @can('user_delete')
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" 
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

        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons });

    });

</script>
@endsection