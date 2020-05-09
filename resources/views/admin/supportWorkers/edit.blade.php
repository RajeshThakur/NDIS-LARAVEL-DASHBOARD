@extends('layouts.admin')
@section('content')


<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('sw.title_singular') }}
    </div>

    <div class="card-body">


        <div class="tab-menu">
            <ul>
                <li><a href="{{ route("admin.support-workers.edit", [$supportWorker->user_id]) }}" class="tab-a {{ $activeTabInfo['tab'] == 'edit'? 'active-a':'' }}" data-id="tab1">Personal Details</a></li>
                <li><a href="{{ route("admin.support-workers.linked-participants", [$supportWorker->user_id]) }}" class="tab-a {{ $activeTabInfo['tab'] == 'linked-participants'? 'active-a':'' }}" data-id="tab1">Linked Participants</a></li>
                <li><a href="{{ route("admin.support-workers.payment-history", [$supportWorker->user_id]) }}" class="tab-a {{ $activeTabInfo['tab'] == 'payment-history'? 'active-a':'' }}" data-id="tab1">Payment History</a></li>
                <li><a href="{{ route("admin.support-workers.bookings", [$supportWorker->user_id]) }}" class="tab-a {{ $activeTabInfo['tab'] == 'bookings'? 'active-a':'' }}" data-id="tab4">Service Bookings</a></li>
                <li><a href="{{ route("admin.support-workers.documents", [$supportWorker->user_id]) }}" class="tab-a {{ $activeTabInfo['tab'] == 'documents'? 'active-a':'' }}" data-id="tab2">Documentation</a></li>
                {{-- <li><a href="{{ route("admin.support-workers.availability", [$supportWorker->user_id]) }}" class="tab-a {{ $activeTabInfo['tab'] == 'availability'? 'active-a':'' }}" data-id="tab3">Support Worker Availability</a></li> --}}
 
                <li><a href="{{ route("admin.support-workers.notes", [$supportWorker->user_id]) }}" class="tab-a {{ $activeTabInfo['tab'] == 'notes'? 'active-a':'' }}" data-id="tab5">Support Worker Notes</a></li>
            </ul>
        </div>
        
        
        @include($activeTabInfo['file'])
        
        

    </div>
</div>

@endsection

@if( !$supportWorker->is_onboarding_complete ) 
    @include( 'admin.supportWorkers.onboarding' )
@endif
