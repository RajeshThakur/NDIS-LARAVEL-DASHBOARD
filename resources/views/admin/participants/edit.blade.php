@extends('layouts.admin')
@section('content')


<div class="card">
    <div class="card-header">
        {{ trans('participants.title') }} {{ $activeTabInfo['title'] }}
    </div>

    <div class="card-body">

        <div class="tab-menu">
            <ul>
                <li>
                    <a href="{{ route("admin.participants.edit", [$participant->id]) }}" class="tab-a {{ $activeTabInfo['tab'] == 'edit'? 'active-a':'' }}" data-id="tab1">
                        {{ trans('participants.tabs.details') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route("admin.participants.documents", [$participant->user_id]) }}" class="tab-a {{ $activeTabInfo['tab'] == 'documents'? 'active-a':'' }}" data-id="tab2">
                        {{ trans('participants.tabs.documents') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route("admin.participants.availability", [$participant->user_id]) }}" class="tab-a {{ $activeTabInfo['tab'] == 'availability'? 'active-a':'' }}" data-id="tab3">
                            <span class="hideon-tab">{{ trans('participants.title') }} </span>{{ trans('participants.tabs.availability') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route("admin.participants.bookings", [$participant->user_id]) }}" class="tab-a {{ $activeTabInfo['tab'] == 'bookings'? 'active-a':'' }}" data-id="tab4">
                            <span class="hideon-tab">{{ trans('participants.title') }} </span>{{ trans('participants.tabs.bookings') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route("admin.participants.notes", [$participant->user_id]) }}" class="tab-a {{ $activeTabInfo['tab'] == 'notes'? 'active-a':'' }}" data-id="tab5">
                        <span class="hideon-tab">{{ trans('participants.title') }} </span>{{ trans('participants.tabs.notes') }}
                    </a>
                </li>
            </ul>
        </div>
        
        
        @include($activeTabInfo['file'])
        
        
    </div>
</div>

@endsection

@if( !$participant->is_onboarding_complete )
    @include( 'admin.participants.onboarding' )
@endif


