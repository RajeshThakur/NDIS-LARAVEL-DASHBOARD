@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('documents.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('documents.fields.title') }}
                        </th>
                        <th>
                            {{ trans('documents.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrationGroups as $key => $registrationGroup)
                        <tr data-entry-id="{{ $registrationGroup->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $registrationGroup->title ?? '' }}
                            </td>
                            <td>
                                {{ App\RegistrationGroup::STATUS_SELECT[$registrationGroup->status] ?? '' }}
                            </td>
                            <td>
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
                                        {!! 
                                            Form::submit(trans('global.delete'))->attrs(["class"=>"btn btn-xs btn-danger"]) 
                                        !!}
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