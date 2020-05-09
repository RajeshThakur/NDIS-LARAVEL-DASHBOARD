@extends('layouts.admin')
@section('content')
<div class="card">   
    <div class="card-header">
        <div class="row">
            <a href="{{ url('admin/reports')}}"><span><i class="fa fa-arrow-left left-arrow-back" aria-hidden="true"></i></span></a>
            <div class="pageTitle">
                <h2>Reports - Support Worker - Service Bookings</h2>
            </div>
            
        </div>
    </div>

 
    <div class="serchbaar">
            <form action="{{ route("admin.reports.support-workers.service-bookings") }}" method="GET" class="m-0" role="search">
                @csrf
                <div class="row">
                    <div class="col-sm-10">
                        <div class="row">
                            {!!
                                Form::text('member', 'Support Worker', '')->id('member')->placeholder('Support Worker\'s name or email')->size('col-sm-3')
                            !!}
            
                            {!! 
                                Form::customSelect('status', 'Status',  array('completed' => 'Completed','pending' => 'Pending','cancelled' => 'Cancelled' ))->size('col-sm-3') 
                            !!}
                            {!! 
                                Form::date('start_date', 'Start Date')->id('start_date')->size('col-sm-3');
                            !!}
            
                            {!! 
                                Form::date('end_date', 'End Date')->id('end_date')->size('col-sm-3');
                            !!}
                    </div>

                    </div>
    
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
                        <th>
                            Support Worker
                        </th>
                                        
                        <th>
                            Registration item
                        </th>
                        <th>
                            Amount
                        </th>
                        <th>
                            Status
                        </th>

                    </tr>
                </thead>
                <?php $totalAmount = 0; ?>
                @if($booking_orders->isEmpty())
                <tbody>                   
                    <tr >
                        <td>
                            
                        </td> 
                        <td>
                            
                        </td> 
                        <td>
                            No booking found
                        </td> 
                        <td>
                            
                        </td> 
                        <td>
                            
                        </td> 
                    </tr>                
                </tbody>
                @else
                
                <tbody>
                    @foreach($booking_orders as $key => $booking_order)
                        <tr >
                            <td>
                                {{$booking_order->worker->first_name}}
                                {{$booking_order->worker->last_name}}
                            </td>
                                                      
                            <td>
                                {{$booking_order->booking->item_number}}
                            </td>

                            <td>
                                {{ !empty($booking_order->timesheet) ? $booking_order->timesheet->total_amount : '-' }}
                                <?php !empty($booking_order->timesheet) ? $totalAmount += $booking_order->timesheet->total_amount : '' ?>
                            </td>
                            <td>
                                {{$booking_order->status}}
                            </td>
                           
                        </tr>
                    @endforeach
                        <tr >
                            <td>
                            
                            </td>
                                                        
                            <td>
                                    Total Amount:
                            </td>

                            <td>
                                    {{ $totalAmount }}
                            </td>
                            <td>
                            
                            </td>
                            
                        </tr>
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