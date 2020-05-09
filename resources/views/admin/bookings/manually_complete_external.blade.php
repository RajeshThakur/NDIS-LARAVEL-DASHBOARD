@extends('layouts.admin')
@section('content')

<div class="card">

    <div class="">
        <div class="card-header">
            <h2>{{ trans('bookings.incomplete_booking') }} </h2>
        </div>
        <div class="row">
            
        </div>
        <div class="row">
            <div class="card-body">            
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>{{ trans('bookings.fields.booking_type') }}</th>
                            <td>{{ ucfirst($booking_order->booking_type) }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('bookings.fields.status') }}</th>
                            <td>{{ $booking_order->status == config('ndis.booking.statuses.NotSatisfied') ? trans('bookings.statuses.NotSatisfied'): "" }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('bookings.fields.incompletion_reason') }}</th>
                            <td>@php echo issetKey($meta,config('ndis.booking.manual.meta_key.reason'),'N/A'); @endphp</td>
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
            </div>           
        </div>
        </div>
    </div>
    <form action="{{ route("admin.bookings.manually-complete",[$booking_order->id] ) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="booking-document form-mt">
            <div class="row">
                @if( issetKey($meta,config('ndis.booking.manual.meta_key.quote'),0) )
                    {!!
                        Form::text(
                            'booking_manual_total_amount', 
                            trans('bookings.fields.total_amount')
                        )->required()->id('booking_manual_total_amount')->size('col-sm-6')
                    !!}
                    {!!
                        Form::text(
                            'booking_manual_quote_amount',
                            trans('bookings.fields.quote_amount')
                        )->required()->id('booking_manual_quote_amount')->size('col-sm-6')
                    !!}
                @endif

                {{-- {!! 
                    Form::text('title', trans('documents.fields.title'))->id('title')->size('col-sm-6')->help(trans('documents.fields.title_helper')) 
                !!} --}}

                {!! 
                    Form::file('document', trans('documents.fields.document'))->id('document')->size('col-sm-6')->help(trans('documents.fields.document_helper')) 
                !!}  

                {!!
                    Form::textarea(
                        'booking_manual_comment', 
                        trans('bookings.fields.comment')                                    
                    )
                !!}        

                <input type="hidden" id="booking_order_id" name="booking_order_id" class="form-control" value="{{ old('booking_order_id', isset($booking_order) ? $booking_order->id : 0) }}" /> 
                <input type="hidden" id="booking_quote_required" name="booking_quote_required" class="form-control" value="{{ old('booking_quote_required', issetKey($meta,config('ndis.booking.manual.meta_key.quote'),0) ) }}" />
                <input type="hidden" id="participant_id" name="participant_id" class="form-control" value="{{ old('participant_id', isset($bookingInformation) ? $bookingInformation->participant_id : 0) }}" /> 

                <div class="create-new">
                    {!! 
                        Form::submit(trans('global.manual_complete'), 'success')->attrs(["class"=>"btn btn-primary rounded plr-100"])
                    !!}
                    <a class="btn btn-primary rounded plr-100" href="{{ url()->previous() }}">
                            Back
                    </a>
                </div>
            </div>
        </div>    
    </form>

@endsection
@section('scripts')
@parent
<script>
$(function () { 
  $('.datatable:not(.ajaxTable)').DataTable({})
})

</script>
@endsection