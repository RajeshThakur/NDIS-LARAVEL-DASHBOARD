@extends('layouts.admin')
@section('content')

<div class="card">

    <div class="card-header">
        <div class="row">
            <div class="pageTitle">
                <h2>{{ trans('bookings.incomplete_booking') }} </h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card-body incomplete-booking">            
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>{{ trans('bookings.fields.booking_type') }}</th>
                        <td>{{ ucfirst($booking_order->booking_type) }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('bookings.fields.status') }}</th>
                        <td>{{ $booking_order->status == config('ndis.booking.statuses.NotSatisfied') ? trans('bookings.statuses.NotSatisfied') : "" }}</td>                        </tr>
                    <tr>
                        <th>{{ trans('bookings.fields.incompletion_reason') }}</th>
                        <td>
                            <ul>@php 
                                foreach(unserialize($meta['booking_incompletion_reason']) as $key=>$val){
                                    echo "<li>";
                                    echo $val;
                                    echo "</li>";
                                } 
                                // echo issetKey($meta,config('ndis.booking.manual.meta_key.reason'),'N/A'); 
                                @endphp
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('bookings.fields.start_time') }}</th>
                        <td>{{ $booking_order->starts_at }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('bookings.fields.end_time') }}</th>
                        <td>{{ $booking_order->ends_at }}</td>
                    </tr>
                </tbody>
            </table> 
            @php if( checkUserRole('1') ): @endphp
            <a style="margin-top:20px;" class="btn btn-primary rounded" href="{{ url()->previous() }}">
                Back
            </a>   
            @php endif; @endphp        
        </div>           
    </div>   
    
    @php if( !checkUserRole('1') ): @endphp
    <form action="{{ route("admin.bookings.manually-complete",$booking_order->id) }}" method="POST" enctype="multipart/form-data" class="validated">
        @csrf
        @method('PUT')
        <div class="booking-document form-mt">
            <div class="row">
                @if( issetKey($meta,config('ndis.booking.manual.meta_key.quote'),0) )                 
                    {!!
                        Form::text('booking_manual_total_amount',trans('bookings.fields.total_amount'))
                        ->required()
                        ->id('booking_manual_total_amount')
                        ->size('col-sm-6')
                        ->attrs([
                            "required"=>"required",
                            "data-rule-required"=>"true",
                            "data-msg-required"=>"Total ammount is required"
                        ])
                    !!}
                    {!!
                        Form::text('booking_manual_quote_amount',trans('bookings.fields.quote_amount'))
                        ->required()
                        ->id('booking_manual_quote_amount')
                        ->size('col-sm-6')
                        ->attrs([
                            "required"=>"required",
                            "data-rule-required"=>"true",
                            "data-msg-required"=>"Quote ammount is required"
                        ])
                    !!}
                @endif

                {!!
                    Form::textarea(
                        'booking_manual_comment', 
                        trans('bookings.fields.comment')                                    
                    )
                !!}     


                <input type="hidden" id="booking_order_id" name="booking_order_id" class="form-control" value="{{ old('booking_order_id', isset($booking_order) ? $booking_order->id : 0) }}" /> 
                <input type="hidden" id="booking_quote_required" name="booking_quote_required" class="form-control" value="{{ old('booking_quote_required', issetKey($meta,config('ndis.booking.manual.meta_key.quote'),0) ) }}" /> 

                <div class="create-new col-sm-12">
                    {!! 
                        Form::submit(trans('global.manual_complete'), 'success')->attrs(["class"=>"btn btn-primary rounded plr-100"])
                    !!}

                    <a class="btn btn-primary rounded plr-100 ml-40" href="{{ url()->previous() }}">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </form>
    @php endif; @endphp
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