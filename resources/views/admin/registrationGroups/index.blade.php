@extends('layouts.admin')
@section('content')
 {{-- @can('registration_group_create')
    <div style="margin-bottom: 10px;" class="row mt-button">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.registration-groups.create") }}">
                {{ trans('global.add') }} {{ trans('global.registrationGroup.title_singular') }}
            </a>
        </div>
    </div>
@endcan  --}}
<div class="card">
    {{-- <div class="card-header">
        {{ trans('global.registrationGroup.title_singular') }} {{ trans('global.list') }}
    </div>  --}}
    


    <div class="card-header">

        <div class="row">
            <div class="pageTitle">
                <h2>
                    {{ trans('global.registration_group.registration_group_List') }}
                </h2>
            </div>
            <div class="icons ml-auto order-last" id="intro_step1"  data-intro="Add to Create Registration Group List">
                <a class="btn btn-success hint--top rounded" aria-label="Add Participant" href="{{ route("admin.registration-groups.create") }}">{{ trans('global.registration_group.registration_group_button') }}</a>
            </div>
        </div>
    </div>
    {{-- <div class="serchbaar">
        <form action="http://localhost:8000/admin/registrationGroups" method="GET" class="m-0" role="search">
            <div class="input-group">
                <input type="text" class="form-control external-service  badge-pill bg-white" name="q" value="" placeholder="First Name, Last Name or Email..">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"><img class="search" src="{{url('img/search.png')}}" alt="NDIS" /></span>
                    </button>
                </span>
            </div>
        </form>
    </div> --}}
    {{-- <div class="Search-Results">
        <h2>Search Results</h2>
    </div> --}}

   <div class="serchbaar mt-3" data-step="3"  data-intro="Add to Create Registration Group List">
        <form action="http://localhost:8000/admin/permissions" method="GET" class="m-0" role="search">

            <div class="input-group">
                {!! 
                    Form::text('q',  '', '' )->placeholder('First Name, Last Name or Email..')->attrs(["class"=>"badge-pill bg-white"])
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
                            {{ trans('global.registrationGroup.fields.title') }}
                        </th>
                        <th>
                            {{ trans('global.registrationGroup.fields.status') }}
                        </th>
                        {{-- <th>
                            &nbsp;
                        </th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrationGroups as $key => $registrationGroup)
                        <tr data-href="{{ route('admin.registration-groups.edit', $registrationGroup->id) }}" data-entry-id="{{ $registrationGroup->id }}">
                            <td>

                            </td>
                            <td>
                                 <a class="btn btn-xs btn-info" href="{{ route('admin.registration-groups.edit', $registrationGroup->id) }}">{{ $registrationGroup->title ?? '' }}</a>
                            </td>
                            <td>
                                 <a class="btn btn-xs btn-info" href="{{ route('admin.registration-groups.edit', $registrationGroup->id) }}">
                                    {{ App\RegistrationGroup::STATUS_SELECT[$registrationGroup->status] ?? '' }}</a>
                            </td>
                            {{-- <td>
                                @can('registration_group_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.registration-groups.show', $registrationGroup->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan
                                @can('registration_group_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.registration-groups.edit', $registrationGroup->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @can('registration_group_delete')
                                    <form action="{{ route('admin.registration-groups.destroy', $registrationGroup->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
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

        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons });

})

</script>
@endsection