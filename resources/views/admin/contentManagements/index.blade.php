@extends('layouts.admin')
@section('content')
@can('content_management_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.cms.managements.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.contentManagement.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.contentManagement.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive cursor-custom">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contentManagements as $key => $contentManagement)
                        <tr data-entry-id="{{ $contentManagement->id }}">
                            <td>

                            </td>
                            <td>
                                @can('content_management_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.cms.managements.show', $contentManagement->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan
                                @can('content_management_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.cms.managements.edit', $contentManagement->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @can('content_management_delete')
                                    <form action="{{ route('admin.cms.managements.destroy', $contentManagement->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
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

        
    })

</script>
@endsection