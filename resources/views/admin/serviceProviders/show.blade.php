@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{-- {{ trans('global.show') }}  --}}
        {{ trans('serviceProvider.title') }}
    </div>

    <div class="card-body">
        <div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('serviceProvider.fields.first_name') }}
                        </th>
                        <td>
                            {{ $serviceProvider->first_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('serviceProvider.fields.last_name') }}
                        </th>
                        <td>
                            {{ $serviceProvider->last_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('serviceProvider.fields.email') }}
                        </th>
                        <td>
                            {{ $serviceProvider->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('serviceProvider.fields.mobile') }}
                        </th>
                        <td>
                            {{ $serviceProvider->mobile }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('serviceProvider.fields.address') }}
                        </th>
                        <td>
                            {{ $serviceProvider->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('serviceProvider.fields.registration_groups') }}
                        </th>
                        <td>
                            {{ $serviceProvider->registration_groups->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('serviceProvider.fields.service_provided') }}
                        </th>
                        <td>
                            {{ $serviceProvider->service_provided }}
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