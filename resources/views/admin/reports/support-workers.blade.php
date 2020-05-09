@extends('layouts.admin')
@section('content')
<div class="card">   
    <div class="card-header">
        <div class="row">
                
            <a href="{{ url('admin/reports')}}"><span><i class="fa fa-arrow-left" aria-hidden="true"></i></span></a>
            <div class="pageTitle">
            <h2>Reports - Support Worker Bookings</h2>
            </div>            
        </div>
    </div>

 
    <div class="serchbaar">
            <form action="{{ route("admin.reports.service-bookings") }}" method="GET" class="m-0" role="search">
                @csrf
                <div class="row">                    
                    {!!
                        Form::text('member', 'Support Worker', '')->size('col-sm-10')->id('member')->placeholder('External Services, Support Worker etc.')
                    !!}
    
{{--     
                    {!! 
                        Form::date('start_date', 'Start Date')->size('col-sm-3')->id('start_date');
                    !!}
    
                    {!! 
                        Form::date('end_date', 'End Date')->size('col-sm-3')->id('end_date');
                    !!}
     --}}
                    <div class="col-md-2">
                        <div class="input-group">
                            <label for="end_date">&nbsp;</label>
                            <button type="submit" class="btn btn-success rounded">
                                <span class="glyphicon glyphicon-search"><i class="fa fa-search"></i></span>
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
                        {{-- <th width="10">

                        </th> --}}
                        <th>
                                Support Worker 
                        </th>
                        <th>
                                Participant
                        </th>
                        <th>
                                Address / Support Location
                        </th>
                        <th>
                                Start Time
                        </th>
                        <th>
                                End Time
                        </th>
                        <th>
                                Date
                        </th>
                    </tr>
                </thead>
                @if($bookings->isEmpty())

                <tbody>                   
                    <tr >
                        <td>
                            
                        </td> 
                        <td>
                            
                        </td> 
                        <td>
                            No service booking found
                        </td> 
                        <td>
                            
                        </td> 
                        <td>
                            
                        </td> 
                    </tr>                
                </tbody>
                @else
                <tbody>
                    @foreach($bookings as $key => $booking)
                        <tr data-entry-id="{{ $booking->id }}">
                            <td>
                                @can('service_booking_edit')
                                    @if($booking->service_type=='support_worker')
                                        <a class="" href="{{ route('admin.bookings.edit', $booking->id) }}">
                                            {{ $booking->supportWorker->first_name ?? '' }}
                                            {{ $booking->supportWorker->last_name ?? '' }}

                                        </a>
                                    @endif
                                    @if($booking->service_type=='external_service')
                                        <a class="" href="{{ route('admin.bookings.edit', $booking->id) }}">
                                            {{ $booking->serviceProvider->first_name ?? '' }}
                                            {{ $booking->serviceProvider->last_name ?? '' }}

                                        </a>
                                    @endif
                                @endcan
                            </td>
                            <td>
                                @can('service_booking_edit')
                                    <a class="" href="{{ route('admin.bookings.edit', $booking->id) }}">
                                        {{ $booking->participant->first_name ?? '' }}
                                        {{ $booking->participant->last_name ?? '' }}
                                    </a>
                                @endcan
                            </td>
                           
                            <td>
                                {{ $booking->location ?? '' }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($booking->starts_at)->format('H:i:s') ?? '' }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($booking->ends_at)->format('H:i:s') ?? '' }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($booking->ends_at)->format('d-m-Y') ?? '' }}
                            </td>
                           
                           
                        </tr>
                    @endforeach
                </tbody>
                @endif                
            </table>

            @if( ! $bookings->isEmpty())
            <div class="account-sub-button">
                <div class="create-new edit-new participant-notes">
                    <ul>
                        <li><button class="btn btn-primary btn btn-primary  plr-100 rounded" type="submit" onClick="window.print()">Print</button></li>
                        <li class="timesheet-dropdown">
                            <button class="btn btn-primary btn btn-secondary plr-100 ml-30 rounded download" type="submit">Download 
                                <span><i class="fa fa-download" aria-hidden="true"></i></span>
                            </button>
                            {{-- <ul class="show-list">
                                <li><a href="#">Demo 1</a></li>
                                <li><a href="#">Demo 2 </a></li>
                            </ul> --}}
                        </li>
                    </ul>
                </div>
            </div>
            @endif  
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
   

</script>
@endsection