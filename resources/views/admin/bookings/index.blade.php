@extends('layouts.admin')
@section('content')

<div class="card">

    <div class="card-header">
        <div class="row">
            <div class="pageTitle">
                <h2>{{ trans('bookings.title_singular') }} {{ trans('global.list') }}</h2>
            </div>
            @php if( !checkUserRole('1') ): @endphp
            <div class="icons ml-auto order-last" id="intro_step1"  data-intro="Add to create Service Booking list">
                @can('service_booking_create')
                    <a class="btn btn-success hint_top rounded" aria-label="{{ trans('global.add') }} {{ trans('bookings.title_singular') }}" href="{{ route("admin.bookings.create") }}">
                        {{ trans('global.add') }} {{ trans('bookings.title_singular') }}
                    </a>
                @endcan
            </div>
            @php endif; @endphp
        </div>
    </div>
    
    <div class="serchbaar mt-3" id="intro_step2"  data-intro="Filter Participants/supportworker">
        <form action="{{ route("admin.bookings.index") }}" method="GET" class="m-0" role="search">
            <div class="row">
                
                {!! 
                    Form::text('member', 'Participant/Support', isset($searchMember)?$searchMember:'')->size('col-sm-4')->id('member')->placeholder('Participant, Support Worker etc.')
                !!}

                {!! 
                    Form::date('start_date', 'Start Date', isset($searchStartDate)?$searchStartDate:'')->size('col-sm-3')->id('start_date');
                !!}

                {!! 
                    Form::date('end_date', 'End Date',isset($searchEndDate)?$searchEndDate:'')->size('col-sm-3')->id('end_date');
                !!}

                <div class="col-md-2">
                    <label for="end_date" class="">&nbsp;</label>
                    <div class="input-group">
                        <button type="submit" class="btn btn-success col rounded">
                            <span class="glyphicon glyphicon-search"><i class="fa fa-search text-white"></i></span>
                        </button>
                    </div>
                </div>
                


            </div>
        </form>
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
                        <th>
                            {{ trans('bookings.fields.service_type') }}
                        </th>
                        <th>
                            {{ trans('bookings.fields.starts_at') }}
                        </th>
                        <th>
                            {{ trans('bookings.fields.ends_at') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if( count($bookings) )
                        @foreach($bookings as $key => $booking)
                            <tr data-href="{{ route('admin.bookings.edit', [ $booking->order_id] ) }}" data-entry-id="{{ $booking->order_id }}" >
                                <td>
                                    <a href="{{ route('admin.bookings.edit', [ $booking->order_id] ) }}">
                                        @can('service_booking_edit')
                                                {{ $booking->participant->first_name ?? '' }}
                                                {{ $booking->participant->last_name ?? '' }}
                                        @endcan
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.bookings.edit', [ $booking->order_id] ) }}">

                                        @if( $booking->service_type == 'support_worker' )
                                    
                                                {{ $booking->supportWorker->first_name ?? '' }}
                                                {{ $booking->supportWorker->last_name ?? '' }}
                                        @endif
                                        @if( $booking->service_type == 'external_service' )
                                        
                                                {{ $booking->serviceProvider->first_name ?? '' }}
                                                {{ $booking->serviceProvider->last_name ?? '' }}
                                            
                                        @endif
                                    </a>
                                </td>
                                <td>
                                        <a href="{{ route('admin.bookings.edit', [ $booking->order_id] ) }}">

                                            {{ regGroupTitleByID($booking->registration_group->parent_id) }} <br/>
                                            {{-- <small>( {{ $booking->registration_group->item_number ?? '' }} )</small> --}}
                                            <small>( {{ $booking->registration_group->title ?? '' }} )</small>
                                        </a>
                                </td>
                                <td>
                                        <a href="{{ route('admin.bookings.edit', [ $booking->order_id] ) }}">

                                            {{ $booking->service_type ? ucwords(str_replace('_', ' ',$booking->service_type)) : '' }}
                                        </a>
                                </td>
                                <td>
                                        <a href="{{ route('admin.bookings.edit', [ $booking->order_id] ) }}">

                                            {{ dbtoDatetime($booking->starts_at) }}
                                        </a>
                                </td>
                                <td>
                                        <a href="{{ route('admin.bookings.edit', [ $booking->order_id] ) }}">

                                            {{ dbtoDatetime($booking->ends_at) }}
                                        </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="12" class="text-center">
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
        
        localStorage.removeItem("is_popup_closed");

        var introGiven = localStorage.getItem("servicebooking_intro_given");
        if(!introGiven){
            introJs().start();
            localStorage.setItem("servicebooking_intro_given", true);
        }

        $('*[data-href]').on("click",function(){
            window.location = $(this).data('href');
            return false;
        });
        $("td > a").on("click",function(e){
            e.stopPropagation();
        });

        $('.datatable:not(.ajaxTable)').DataTable({})

        
        // let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        // $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons });
    })



// $(function () { 

//     localStorage.removeItem("is_popup_closed");

//         var introGiven = localStorage.getItem("participant_intro_given");
//         if(!introGiven){
//             introJs().start();
//             localStorage.setItem("participant_intro_given", true);
//         }

//   $('.datatable:not(.ajaxTable)').DataTable({})
// })

</script>
@endsection