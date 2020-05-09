
    <form action="{{ route("admin.bookings.edit.incident.save", [$booking->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" id="booking_order_id" name="booking_order_id" class="form-control" value="{{ old('booking_order_id', isset($booking) ? $booking->order_id : 0) }}" />
    
        <div class="booking-document form-mt">
            <div class="row">
                
                {!!
                    Form::textarea(
                        'incident_details', 
                        trans('opforms.fields.incident_details'), 
                        old('incident_details', isset($booking->incident->incident_details) ? $booking->incident->incident_details : '')
                    )
                !!}

                {!!
                    Form::textarea(
                        'any_injuries', 
                        trans('opforms.fields.any_injuries'), 
                        old('any_injuries', isset($booking->incident->any_injuries) ? $booking->incident->any_injuries : '')
                    )
                !!}

                {!! 
                    Form::textarea(
                        'any_damage', 
                        trans('opforms.fields.any_damage'), 
                        old('any_damage', isset($booking->incident->any_damage) ? $booking->incident->any_damage : '')
                        )
                !!}

                {!! 
                    Form::textarea(
                        'cause_of_incident', 
                        trans('opforms.fields.cause_of_incident'), 
                        old('cause_of_incident', isset($booking->incident->cause_of_incident) ? $booking->incident->cause_of_incident : '')
                    )
                !!}
                
                {!! 
                    Form::textarea(
                        'actions_to_eliminate',
                        trans('opforms.fields.actions_to_eliminate'), 
                        old('actions_to_eliminate', isset($booking->incident->actions_to_eliminate) ? $booking->incident->actions_to_eliminate : '')
                    )
                !!}

                {!! 
                    Form::textarea(
                        'management_comments', 
                        trans('opforms.fields.management_comments'), 
                        old('management_comments', isset($booking->incident->management_comments) ? $booking->incident->management_comments : '')
                    )
                !!}

                <input type="hidden" id="booking_id" name="booking_id" class="form-control" value="{{ old('booking_id', isset($booking) ? $booking->id : 0) }}" />

                <input type="hidden" id="template_id" name="template_id" class="form-control" value="8" />

                <input type="hidden" name="user_id" value='7'>

                <div class="create-new col-sm-12">
                    {!! 
                        Form::submit(trans('global.send'), 'primary')->attrs(["class"=>"btn btn-primary rounded plr-100"]) 
                    !!}
                </div>
            </div>
        </div>
    </form>




@section('scripts')
@parent
<script>
$(function () {
    
})

</script>
@endsection