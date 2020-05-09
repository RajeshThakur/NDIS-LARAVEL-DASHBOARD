@extends('layouts.admin')
@section('content')

<div class="card">

    <div class="card-header">
        <div class="row">
            <div class="pageTitle">
                <h2>{{ trans('bookings.manually_complete_list') }} {{ trans('global.list') }}</h2>
            </div>
           
        </div>
    </div>
    


    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>
                            {{ trans('bookings.fields.participant') }}
                        </th>
                        <th>
                            {{ trans('bookings.fields.support_worker') }}
                        </th>
                        <th>
                            {{ trans('bookings.fields.registration_group') }}
                        </th>
                       
                        {{-- <th>
                            {{ trans('bookings.fields.starts_at') }}
                        </th> --}}
                        <th>
                            {{ trans('bookings.fields.ended_at') }}
                        </th>
                        <th>
                            {{ trans('bookings.fields.service_type') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                     @if($bookings->count())
                    @foreach($bookings as $key => $booking)
                        <tr data-entry-id="{{ $booking->order_id }}">
                            <td>
                                @can('service_booking_edit')
                                    <a class="" href="{{ route('admin.bookings.manually-complete', [ $booking->order_id]) }}">
                                        {{ $booking->participant->first_name ?? '' }}
                                        {{ $booking->participant->last_name ?? '' }}
                                    </a>
                                @endcan
                            </td>
                            <td>
                                @if( $booking->service_type == 'support_worker' )
                                    <a class="" href="{{ route('admin.bookings.manually-complete', [ $booking->order_id]) }}">
                                        {{ $booking->supportWorker->first_name ?? '' }}
                                        {{ $booking->supportWorker->last_name ?? '' }}
                                    </a>
                                @endif
                                @if( $booking->service_type == 'external_service' )
                                    <a class="" href="{{ route('admin.bookings.manually-complete', [ $booking->order_id]) }}">
                                        {{ $booking->serviceProvider->first_name ?? '' }}
                                        {{ $booking->serviceProvider->last_name ?? '' }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                <a class="" href="{{ route('admin.bookings.manually-complete', [ $booking->order_id]) }}">
                                    {{ regGroupTitleByID($booking->registration_group->parent_id) }} <br/>
                                    {{-- <small>( {{ $booking->registration_group->item_number ?? '' }} )</small> --}}
                                    <small>( {{ $booking->registration_group->title ?? '' }} )</small>
                                </a>
                            </td>
                            
                            {{-- <td>
                                 <a class="" href="{{ route('admin.bookings.manually_complete', [ $booking->order_id]) }}">
                                    {{ $booking->starts_at ? $booking->getDateAttribute($booking->starts_at) : '' }}
                                </a>
                            </td> --}}
                            <td>                                
                                <a class="" href="{{ route('admin.bookings.manually-complete', [ $booking->order_id]) }}">
                                    {{ dbToDatetime( $booking->ends_at ) }}
                                </a>
                            </td>
                            <td>
                                <div class="badge badge-info">
                                    <a  href="{{ route('admin.bookings.manually-complete', [ $booking->order_id]) }}">
                                    {{ $booking->service_type ? ucwords(str_replace('_', ' ',$booking->service_type)) : '' }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="text-center">
                                No Records Found!
                            </td>
                        </tr>
                    @endif
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
  $('.datatable:not(.ajaxTable)').DataTable({})
})

</script>
@endsection