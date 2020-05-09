@extends('layouts.admin')
@section('content')
<div class="card">   
    <div class="card-header">
        <div class="row">
                
            <a href="{{ url('admin/reports')}}"><span><i class="fa fa-arrow-left left-arrow-back" aria-hidden="true"></i></span></a>
            <div class="pageTitle">
            <h2>Reports - Service Bookings for funding reports for the Participant</h2>
            </div>            
        </div>
    </div>

 
    <div class="serchbaar">
            <form action="{{ route("admin.reports.service-bookings.funding") }}" method="GET" class="m-0" role="search">
                @csrf
                <div class="row">                    
                    {!!
                        Form::text('member', 'Participant', '')->size('col-sm-10')->id('member')->placeholder('Participant name or email')
                    !!}
    
    
                    <div class="col-md-2">
                        <div class="input-group">
                            <label for="end_date">&nbsp;</label>
                            <button type="submit" class="btn btn-success rounded">
                                <span class="glyphicon glyphicon-search"><i class="fa fa-search white-icon"></i></span>
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
                                Participant 
                        </th>
                        <th>
                                Provider
                        </th>
                        <th>
                                NDIS number
                        </th>
                        <th>
                                Total Funding allocated
                        </th>
                        <th>
                                Total funding remaining
                        </th>
                       
                        {{-- <th>
                                Total Funding allocated for each Registration group
                        </th>
                        <th>
                                Total Funding allocated for each Registration group remaining

                        </th> --}} 
                        <th>
                                Service provided
                        </th>
                        <th>
                                Date of service
                        </th>
                        <th>
                                Service cost 
                        </th>
                        <th>
                                Funds remaining after that service
                        </th>
                    </tr>
                </thead>
                @if($booking_orders->isEmpty())

                <tbody>                   
                    <tr >
                        {{-- <td>
                            
                        </td> 
                        <td>
                            
                        </td>  --}}
                        <td colspan="12" class="text-center">
                            No service booking found
                        </td> 
                        {{-- <td>
                            
                        </td> 
                        <td>
                            
                        </td>  --}}
                    </tr>                
                </tbody>
                @else
                <tbody>
                    @foreach($booking_orders as $key => $booking_order)
                        <tr data-entry-id="{{ $booking_order->id }}">
                            <td>
                               {{ $booking_order->participant->first_name }}
                               {{ $booking_order->participant->last_name }}
                            </td>
                            <td>
                                {{\Auth::user()->first_name}}
                                {{\Auth::user()->last_name}}
                            </td>
                           
                            <td>
                                {{ $booking_order->participant->ndis_number }}
                            </td>
                            <td>
                                {{ $booking_order->participant->budget_funding  }}
                            </td>
                            <td>
                                {{ $booking_order->participant->funds_balance  }}
                            </td>
                            <td>
                                {{ $booking_order->booking->service_type  }} 
                            </td>
                            <td>
                                {{ $booking_order->starts_at  }} 
                            </td>
                           
                            <td>
                                {{ $booking_order->timesheet ? $booking_order->timesheet->total_amount : '-'  }}
                            </td>
                           
                            <td>
                                {{ $booking_order->participant->funds_balance  }} 
                            </td>
                           
                           
                        </tr>
                    @endforeach
                </tbody>
                @endif                
            </table>

            @if( ! $booking_orders->isEmpty())
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
    $(function () {
        
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons });
    })
   

</script>
@endsection