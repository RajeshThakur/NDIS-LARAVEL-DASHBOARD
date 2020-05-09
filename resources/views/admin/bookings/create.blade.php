@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('bookings.title_singular') }}
    </div>
    <div class="card-body">

        <div id="serviceFrm" role="tabpanel">
            
            <form action="{{ route("admin.bookings.store") }}" id="swbooking" method="POST" class="validated" data-type="support_worker" enctype="multipart/form-data">
                @csrf

                <div class="booking-tabs">
                    <div id="service_type_selector" class="col-sm-12 mb-0 service-booking-tab">
                        <div class="form-group">
                            <label for="service_type" class="">Booking Type *</label>
                            <div class="input-group">
                                <input id="toggle-on" class="toggle toggle-left service_type" name="service_type" value="support_worker" type="radio" checked>
                                <label for="toggle-on" class="toggle-label col-6 sb-caret-icon-left">Support Worker</label>
                                <input id="toggle-off" class="toggle toggle-right service_type" name="service_type" value="external_service" type="radio">
                                <label for="toggle-off" class="toggle-label col-6 sb-caret-icon-right">External Service</label>
                            </div>
                            <small class="form-text text-muted">&nbsp;</small>
                        </div>
                    </div>
                </div>

                <div class="row">

                    {!!
                        Form::select('participant_id',trans('bookings.fields.participant'),$participants,($editParticipantId ? $editParticipantId : old('participant_id')))
                        ->id('participant')
                        ->required()
                        ->size('col-sm-6')
                        ->attrs([
                            "required"=>"required",
                            "data-rule-required"=>"true",
                            "data-msg-required"=>trans('errors.service_booking.participant_id')
                        ])
                    !!}
            
                    {!!
                        Form::location('location',trans('bookings.fields.location'),old('location', isset($booking) ? $booking->location : ''),old('lat', isset($booking) ? $booking->lat : ''),old('lng', isset($booking) ? $booking->lng : ''))
                        ->id('inp-location')
                        ->required()
                        ->help( trans('bookings.fields.location_helper') )
                        ->size('col-sm-6')
                        ->attrs([
                            "required"=>"required",
                            "data-rule-required"=>"true",
                            "data-msg-required"=>trans('errors.service_booking.location')
                        ])
                    !!}
            
                    {!! 
                        Form::date('date', trans('bookings.fields.date'), old('date', isset($booking->date) ? $booking->date : ''))
                        ->id('dt-date')
                        ->size('col-sm-6')
                        ->required()
                        ->help(trans('bookings.fields.date_helper'))
                        ->attrs([
                            "required"=>"required",
                            "data-rule-required"=>"true",
                            "data-msg-required"=>trans('errors.service_booking.date'),
                            "data-rule-dateFormat"=>"true",
                            "data-msg-dateFormat"=>trans('errors.service_booking.date_format')
                        ])
                    !!}
            
                    <div class="col-sm-6" id="start-end-time">
                        <div class="row ml-mr-none">
                            {!! 
                                Form::time('start_time', trans('bookings.fields.start_time'), old('start_time', isset($booking->start_time) ? $booking->start_time : '' ))
                                ->size('col-sm-6')
                                ->required()
                                ->help(trans('bookings.fields.start_time_helper'))
                                ->id('dt-start_time')
                                ->attrs([
                                    "required"=>"required",
                                    "data-rule-required"=>"true",
                                    "data-msg-required"=>trans('errors.service_booking.start_time')                                    
                                ])
                            !!}
                            {!! 
                                Form::time('end_time', trans('bookings.fields.end_time'), old('end_time', isset($booking->end_time) ? $booking->end_time : ''))
                                ->size('col-sm-6')
                                ->required()
                                ->help(trans('bookings.fields.end_time_helper'))
                                ->id('dt-end_time')
                                ->attrs([
                                    "required"=>"required",
                                    "data-rule-required"=>"true",
                                    "data-msg-required"=>trans('errors.service_booking.end_time'),
                                ])
                            !!}
                        </div>
                    </div>
                    
                    {!! 
                        Form::select('registration_group_id', trans('bookings.fields.registration_group'),  ['Please select participant first..',''] )
                        ->id('registration_group_id')
                        ->size('col-sm-6')
                        ->help(trans('bookings.fields.registration_group_helper'))
                        ->required()
                        ->attrs([
                            "required"=>"required",
                            "data-rule-required"=>"true",
                            "data-msg-required"=>trans('errors.service_booking.registration_group_id')
                        ])
                    !!}
            
                    {!! 
                        Form::select('item_number', trans('bookings.fields.item_number'),  ['Please select registration group first..',''] )
                        ->id('item_number')
                        ->size('col-sm-6')
                        ->help(trans('bookings.fields.item_number_helper'))
                        ->required()
                        ->attrs([
                            "required"=>"required",
                            "data-rule-required"=>"true",
                            "data-msg-required"=>trans('errors.service_booking.item_number')
                        ])
                    !!}
            
                    {!! 
                        Form::select('supp_wrkr_ext_serv_id', trans('bookings.fields.support_worker'),  ['Please select above fields',''] )
                        ->id('supp_wrkr_ext_serv_id')
                        ->size('col-sm-6')
                        ->help(trans('bookings.fields.support_worker_helper'))
                        ->required()
                        ->attrs([
                            "required"=>"required",
                            "data-rule-required"=>"true",
                            "data-msg-required"=>trans('errors.service_booking.supp_wrkr_ext_serv_id')
                        ])
                    !!}

                    {!! 
                        Form::select('is_recurring', trans('bookings.fields.recurring'),  [ 0 => 'No', 1=>"Yes"] )
                        ->id('is_recurring')
                        ->size('col-sm-6')
                        ->help(trans('bookings.fields.recurring_help'))
                        ->required();
                    !!}

                </div>

                <div class="row" id="recurringFields" style="display:none">
                    {!! 
                        Form::select('recurring_frequency',trans('bookings.fields.recurring_frequency'), ['none' => 'Do Not Repeat','weekly'=>'Weekly', 'fortnightly'=>"Fortnightly", 'monthly'=>"Monthly", "yearly"=>"Yearly"])
                        ->id('recurring_frequency')
                        ->size('col-sm-6')
                        ->help(trans('bookings.fields.recurring_frequency_help'))
                        ->required();
                    !!}
                    {!! 
                        Form::number('recurring_num', trans('bookings.fields.recurring_num') )
                        ->id('recurring_num')
                        ->size('col-sm-6')
                        ->help(trans('bookings.fields.recurring_num_help'))
                        ->required();
                    !!}
                </div>
                    
            
                <div class=" buttom-section">
                    {!! Form::button(trans('global.save'), 'primary', 'normal')->attrs(["class"=>"rounded"])->id("saveBooking") !!}
                </div>
            </form>            

        </div>

    </div>
</div>
@endsection

@include( 'admin.bookings.scripts' )

@section('scripts')
    @parent
    <script>
        jQuery(document).ready( function(){
            // loadParticipantDetails(elm, elVal);
            jQuery("#dt-start_time").on('input', function(ev){
                $estEndTime = moment(  jQuery(this).val(), "LT");
                // console.log($estEndTime);
                jQuery("#dt-end_time").val( $estEndTime.add(1, 'h').format('LT') );
            })

          
            $('.timepicker').datetimepicker({
                format: 'LT',
                stepping:15
            });
        })
    </script>
@endsection