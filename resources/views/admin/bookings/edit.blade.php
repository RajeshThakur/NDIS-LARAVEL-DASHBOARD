@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('bookings.title_singular') }}
    </div>

    <div class="card-body">


        <div class="tab-menu">
                <ul>
                    <li>
                        <a href="{{ route("admin.bookings.edit", [$booking->order_id]) }}" class="tab-a {{ $activeTabInfo['tab'] == 'edit'? 'active-a':'' }}" data-id="tab1">
                            {{ trans('bookings.tabs.index') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route("admin.bookings.edit.note", [$booking->order_id]) }}" class="tab-a {{ $activeTabInfo['tab'] == 'note'? 'active-a':'' }}" data-id="tab2">
                            {{ trans('bookings.tabs.add_notes') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route("admin.bookings.edit.contact.participant", [$booking->order_id]) }}" class="tab-a {{ $activeTabInfo['tab'] == 'contact_participant'? 'active-a':'' }}" data-id="tab2">
                            {{ trans('bookings.tabs.contact_participant') }}
                        </a>
                    </li>
                    @if( $booking->service_type == 'support_worker' )
                    <li>
                        <a href="{{ route("admin.bookings.edit.contact.worker", [$booking->order_id]) }}" class="tab-a {{ $activeTabInfo['tab'] == 'contact_worker'? 'active-a':'' }}" data-id="tab2">
                            {{ trans('bookings.tabs.contact_support_worker') }}
                        </a>
                    </li>
                    @endif
                    @if( $booking->service_type == 'external_service' )
                    <li>
                        <a href="{{ route("admin.bookings.edit.invoice", [$booking->order_id]) }}" class="tab-a {{ $activeTabInfo['tab'] == 'invoice'? 'active-a':'' }}" data-id="tab2">
                            {{ trans('bookings.tabs.add_invoice') }}
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="{{ route("admin.bookings.edit.incident", [$booking->order_id]) }}" class="tab-a {{ $activeTabInfo['tab'] == 'incident'? 'active-a':'' }}" data-id="tab2">
                            {{ trans('bookings.tabs.incident_report') }}
                        </a>
                    </li>

                </ul>
            </div>
            
            @include($activeTabInfo['file'])

    </div>
</div>

@endsection