@extends('layouts.admin')
@section('content')


<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('serviceProvider.title_singular') }}
    </div>

    <div class="card-body">


        <div class="tab-menu">
            <ul>
                <li><a href="{{ route("admin.provider.edit", [$serviceProvider->user_id]) }}" class="tab-a {{ $activeTabInfo['tab'] == 'edit'? 'active-a':'' }}" data-id="tab1">Personal Details</a></li>
                <li><a href="{{ route("admin.provider.documents", [$serviceProvider->user_id]) }}" class="tab-a {{ $activeTabInfo['tab'] == 'documents'? 'active-a':'' }}" data-id="tab2">Documentation</a></li>
            </ul>
        </div>
        
        
        @include($activeTabInfo['file'])
        
        <div class="card-body">    
            @can('participant_delete')
                    @include('template.deleteItem', [ 'destroyUrl' =>  route("admin.provider.destroy", [$serviceProvider->user_id]) ])
            @endcan
        </div>
        

    </div>
</div>

@endsection

@if( !$serviceProvider->is_onboarding_complete )
    @include( 'admin.serviceProviders.onboarding' )
@endif
