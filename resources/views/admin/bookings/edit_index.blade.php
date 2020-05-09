<div id="serviceFrm" role="tabpanel" >

    <form action="{{ route("admin.bookings.store") }}" id="swbooking" data-type="{{old('service_type', isset($booking->service_type) ? $booking->service_type : 'support_worker')}}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- @method('PUT') --}}

        <div class="row">            
            {!!
                Form::select(
                            'participant_id', 
                            trans('bookings.fields.participant'),
                            [$booking->participant->user_id=>$booking->participant->first_name." ".$booking->participant->last_name],
                            (isset($booking) && $booking->participant_id) ? $booking->participant->id : old('participant_id')
                            )
                    ->id('participant')
                    ->required()
                    ->size('col-sm-6')
            !!}
    
            {!!
                Form::location(
                                'location', 
                                trans('bookings.fields.location'), 
                                old('location', isset($booking) ? $booking->location : ''),
                                old('lat', isset($booking) ? $booking->lat : ''),
                                old('lng', isset($booking) ? $booking->lng : '')
                            )
                ->required()
                ->help( trans('bookings.fields.location_helper') )
                ->size('col-sm-6')
            !!}
            
            {!!
                Form::date('date', trans('bookings.fields.date'), old('booking_date', isset($booking->booking_date) ? $booking->booking_date : ''))
                ->size('col-sm-6')
                ->required()
                ->id('dt-date')
                ->help(trans('bookings.fields.date_helper'))
                ->attrs([
                            "class"=>"bookingDate",
                            "required"=>"required",
                            "data-rule-required"=>"true",
                            "data-msg-required"=>trans('errors.service_booking.date'),
                            "data-rule-dateFormat"=>"true",
                            "data-msg-dateFormat"=>trans('errors.service_booking.date_format')
                        ])
            !!}
    
            <div class="col-sm-6">
                <div class="row">
                        {!!
                            Form::time('start_time', trans('bookings.fields.start_time'), old('start_time', isset($booking->start_time) ? $booking->start_time : ''))
                            ->size('col-sm-6')
                            ->required()
                            ->help(trans('bookings.fields.start_time_helper'))
                            ->id('dt-start_time')
                            ->attrs([
                                    "class"=>"bookingTime",
                                    "required"=>"required",
                                    "data-rule-required"=>"true",
                                    "data-msg-required"=>trans('errors.service_booking.start_time')                                    
                                ])
                        !!}
                
                        {!!
                            Form::time('end_time', trans('bookings.fields.end_time'), old('end_time', isset($booking->end_time) ? $booking->end_time : ''))
                            ->size('col-sm-6')
                            ->required()
                            ->id('dt-end_time')
                            ->help(trans('bookings.fields.end_time_helper'))
                            ->id('dt-end_time')
                            ->attrs([
                                    "class"=>"bookingTime",
                                    "required"=>"required",
                                    "data-rule-required"=>"true",
                                    "data-msg-required"=>trans('errors.service_booking.end_time'),
                                ])
                        !!}
                </div>
            </div>
            
            {{-- {!! 
                Form::select('registration_group_id', trans('bookings.fields.registration_group'),  
                                [$booking->registration_group->parent_id => regGroupTitleByID($booking->registration_group->parent_id) ],
                                (isset($booking->registration_group) && $booking->registration_group->parent_id) ? $booking->registration_group->parent_id : old('registration_group_id')
                            )
                ->id('registration_group_id')
                ->size('col-sm-6')
                ->help(trans('bookings.fields.registration_group_helper'))
                ->required();
            !!} --}}
            {!! $editable->result->regGroupDDHTML !!}
    
            {!! 
                Form::select('item_number', trans('bookings.fields.item_number'), 
                                [$booking->registration_group->id => $booking->registration_group->title ],
                                (isset($booking->registration_group) && $booking->registration_group->id) ? $booking->registration_group->id : old('item_number')
                            )
                ->id('item_number')
                ->size('col-sm-6')
                ->help(trans('bookings.fields.item_number_helper'))
                ->required();
            !!}

            @if($booking->service_type=='support_worker')
            {!! 
                Form::select('supp_wrkr_ext_serv_id', trans('bookings.fields.support_worker'),  
                                [ $booking->supportWorker->user_id => $booking->supportWorker->first_name." ".$booking->supportWorker->last_name ],
                                (isset($booking->supportWorker) && $booking->supportWorker->user_id) ? $booking->supportWorker->user_id : old('supp_wrkr_ext_serv_id')
                            )
                ->id('supp_wrkr_ext_serv_id')
                ->size('col-sm-6')
                ->help(trans('bookings.fields.support_worker_helper'))
                ->required();
            !!}
            @endif

            @if($booking->service_type=='external_service')
            {!! 
                Form::select('supp_wrkr_ext_serv_id', trans('bookings.fields.support_worker'),  
                                [ $booking->serviceProvider->user_id => $booking->serviceProvider->first_name." ".$booking->serviceProvider->last_name ],
                                (isset($booking->serviceProvider) && $booking->serviceProvider->user_id) ? $booking->serviceProvider->user_id : old('supp_wrkr_ext_serv_id')
                            )
                ->id('supp_wrkr_ext_serv_id')
                ->size('col-sm-6')
                ->help(trans('bookings.fields.support_worker_helper'))
                ->required();
            !!}
            @endif

            {!! 
                Form::select('is_recurring', trans('bookings.fields.recurring'),  [ 0 => 'No', 1=>"Yes"], $booking->is_recurring )
                ->id('is_recurring')
                ->size('col-sm-6')
                ->help(trans('bookings.fields.recurring_help'))
                ->required();
            !!}

        </div>
        
        <div class="row" id="recurringFields" {{ ($booking->is_recurring==0)?'hidden="true"':'' }}>
            {!! 
                Form::select(
                            'recurring_frequency', 
                            trans('bookings.fields.recurring_frequency'),  
                            [ 'none' => 'Do Not Repeat', 'daily'=>"Daily", 'weekly'=>'Weekly', 'fortnightly'=>"Fortnightly", 'monthly'=>"Monthly", "yearly"=>"Yearly"],
                            $booking->recurring_frequency
                        )
                ->id('recurring_frequency')
                ->size('col-sm-6')
                ->help(trans('bookings.fields.recurring_frequency_help'))
                ->required();
            !!}

            {!! 
                Form::number('recurring_num', trans('bookings.fields.recurring_num'), $booking->recurring_num )
                ->id('recurring_num')
                ->size('col-sm-6')
                ->help(trans('bookings.fields.recurring_num_help'))
                ->required();
            !!}
        </div>
    
    
            <div class="buttom-section">

                <input type="hidden" name="id" value="{{isset($booking) ? $booking->id:0}}" />

                <input type="hidden" name="order_id" value="{{isset($booking) ? $booking->order_id:0}}" />
    
                {!! Form::button(trans('global.save'), 'success', 'normal')->attrs(["class"=>"rounded"])->id("saveBooking") !!}
                
                @can('service_booking_delete')
                    {!! Form::button( trans('global.delete_btn'), 'danger')->attrs(["onclick"=>"return deleteRec();", 'class'=>'rounded']) !!}
                @endcan
            </div>
        </div>
    </form>
    
</div>


@can('service_booking_delete')
    @include('template.deleteItem', [ 'destroyUrl' => route('admin.bookings.destroy', $booking->id) ])
@endcan


@include( 'admin.bookings.scripts' )
@section('scripts')
@parent
<script>
    jQuery(document).ready(function(){
        // elm = jQuery("#participant");
        // loadParticipantDetails(elm, {{$booking->participant->user_id}});

        jQuery('#registration_group_id option[value="{{ $booking->registration_group->parent_id }}"]').attr("selected", "selected");

        jQuery( "#inp-location" ).keyup(function() {
            jQuery('#lat').val('');
            jQuery('#lng').val('');
        });


        $('.bookingDate').datetimepicker({
            //format: 'YYYY-MM-DD',
            format: 'DD-MM-YYYY',
            locale: 'en',
            // minDate:new Date(),
            disabledDates: calDisabledDates,
            // daysOfWeekDisabled: calDaysOfWeekDisabled
        });

        $('.bookingTime').datetimepicker({
            format: 'LT',
            stepping:15
        });

        jQuery("#dt-start_time").on('input', function(ev){
                $estEndTime = moment(  jQuery(this).val(), "LT");
                // console.log($estEndTime);
                jQuery("#dt-end_time").val( $estEndTime.add(1, 'h').format('LT') );
        })

        

    });
</script>
@endsection