@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{-- {{ trans('global.show') }}  --}}
        {{-- {{ trans('bookings.title') }} --}}
        {{ trans('bookings.fields.detail') }}
    </div>

    <div class="card-body">
        <div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('bookings.fields.participant') }}
                        </th>
                        <td>
                            {{ $booking->participant->first_name ?? '' }}
                            {{ $booking->participant->last_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('bookings.fields.starts_at') }}
                        </th>
                        <td>
                            {{ $booking->starts_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('bookings.fields.ends_at') }}
                        </th>
                        <td>
                            {{ $booking->ends_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('bookings.fields.registration_group') }}
                        </th>
                        <td>
                            {{ $booking->registration_group->title ?? '' }}
                            {{ $booking->registration_group->item_n ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('bookings.fields.item_number') }}
                        </th>
                        <td>
                            {{ $booking->item_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('bookings.fields.service_type') }}
                        </th>
                        <td>
                            {{ $booking->service_type }}
                        </td>
                    </tr>
                    <tr>
                        @if( $booking->service_type == 'external_service')
                            <th>
                                {{ trans('bookings.fields.ext_service_provider') }}
                            </th>
                            <td>
                                {{ $booking->ServiceProvider->first_name ?? '' }}
                                {{ $booking->ServiceProvider->last_name ?? '' }}
                            </td>
                        @else                            
                            <th>
                                {{ trans('bookings.fields.support_worker') }}
                            </th>
                            <td>
                                {{ $booking->supportWorker->first_name ?? '' }}
                                {{ $booking->supportWorker->last_name ?? '' }}
                            </td>
                        @endif
                    </tr>
                    <tr>
                        <th>
                            {{ trans('bookings.fields.status') }}
                        </th>
                        <td>
                            {{ trans('bookings.statuses.'.$booking->status) }}
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