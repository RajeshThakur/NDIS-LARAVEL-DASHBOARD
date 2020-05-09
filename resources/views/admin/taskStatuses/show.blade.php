@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('global.taskStatus.title') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('global.taskStatus.fields.name') }}
                    </th>
                    <td>
                        {{ $taskStatus->name }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection