@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('sw.title') }}
    </div>

    <div class="card-body">
        <div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('sw.fields.first_name') }}
                        </th>
                        <td>
                            {{ $supportWorker->first_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('sw.fields.last_name') }}
                        </th>
                        <td>
                            {{ $supportWorker->last_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('sw.fields.email') }}
                        </th>
                        <td>
                            {{ $supportWorker->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('sw.fields.mobile') }}
                        </th>
                        <td>
                            {{ $supportWorker->mobile }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('sw.fields.address') }}
                        </th>
                        <td>
                            {{ $supportWorker->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('sw.fields.registration_groups') }}
                        </th>
                        <td>
                            {{ $supportWorker->registration_groups->title ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-primary rounded" href="{{ url()->previous() }}">
                Back
            </a>
        </div>
    </div>
</div>

@endsection