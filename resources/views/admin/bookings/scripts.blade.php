@section('scripts')
@parent
<script>
    var is_dirty = false,
        userAvailabilityMsgShown = false,
        userAvailability = [];

    function formOperations( formId ){
        
        var participant_id = jQuery("#"+formId+" #participant").val();
        var bookingDate = jQuery("#"+formId+" #dt-date").val();
        var bookingStart = jQuery("#"+formId+" #dt-start_time").val();
        var bookingEnd = jQuery("#"+formId+" #dt-end_time").val();
        var regGroup = jQuery("#"+formId+" #registration_group_id").val();
        var location = jQuery("#"+formId+" #inp-location").val();
        var lat = jQuery("#"+formId+" #lat").val();
        var lng = jQuery("#"+formId+" #lng").val();
        var service_type = jQuery("#"+formId).attr('data-type');

        
        if( 
            !ndis.isEmpty( service_type ) && 
            !ndis.isEmpty( participant_id ) && 
            !ndis.isEmpty( bookingDate ) && 
            !ndis.isEmpty( bookingStart ) && 
            !ndis.isEmpty( bookingEnd ) && 
            !ndis.isEmpty( location ) && 
            !ndis.isEmpty( regGroup )
        ){

            var elm = jQuery("#saveBooking");
            availableSupportWorkers(elm, {
                service_type,
                participant_id,
                bookingDate,
                bookingStart,
                bookingEnd,
                regGroup,
                location,
                lat,
                lng
            })
        }
        
    }


    function checkParticipantAvailability( participantId, date, start_time, end_time ){
        var elm = jQuery("#dt-date");
        ndis.addLoader( elm );
        ndis.ajax(
                '{{ route("admin.bookings.participant.availability") }}',
                'POST',
                { participantId, date, start_time, end_time },
                function(res){
                    if(res.success){
                    }
                    if(res.error){
                        ndis.displayMsg( 'error', res.msg)
                    }
                    ndis.removeLoader( elm );
                }
            );
    }
    

    /**
     * Function to fetch the support workers based on the information below
     * 
     */
    function availableSupportWorkers( elm, data ){
        ndis.addLoader( elm );
        ndis.ajax(
                '{{ route("admin.bookings.participant.bookablesw") }}',
                'POST',
                data,
                function(res){
                    if(res.success){
                        jQuery("#dm-supp_wrkr_ext_serv_id").replaceWith( res.result.swDDHTML )
                    }
                    if(res.error){
                        ndis.displayMsg( 'error', res.msg)
                    }
                    ndis.removeLoader( elm );
                }
            );
    }


    /**
    **  Function that will load the Participant details when a Participant is selected from the drop down
    **  @argument elm jQuery object for an Element
    **  @argument data Object to send in POST
    **/
    function loadParticipantDetails(elm){
        
        var postData = { participant_id : $("#participant").val(), service_type: jQuery('.service_type:checked').val() };

        ndis.addLoader( elm );
        ndis.ajax(
                '{{ route("admin.bookings.participant.details") }}',
                'POST',
                postData,
                function(res){

                    if(res.status){
                        jQuery("#inp-location").val( res.result.address )
                        jQuery("#lat").val( res.result.lat )
                        jQuery("#lng").val( res.result.lng )
                        jQuery("#dm-registration_group_id").replaceWith( res.result.regGroupDDHTML )
                        jQuery("#dm-item_number").replaceWith( res.result.regItemDDHTML )
                        // jQuery("body").append( res.result.script )

                        calDaysOfWeekDisabled = res.result.daysDisabled.split(",");

                        console.log("calDaysOfWeekDisabled", calDaysOfWeekDisabled);
                        

                        // userAvailabilityMsgShown = false;
                        // userAvailability = res.result.daysAvailable;
                        
                        // if("" != res.result.disabledDaysMsg)
                        //     ndis.showToast("Participant Days Availability", res.result.disabledDaysMsg);
                        // $('.datefield').data('DateTimePicker').daysOfWeekDisabled([1, 2]);
                        // $('.datefield').daysOfWeekDisabled([2,4,6])

                    }
                    else{
                        ndis.displayMsg( 'error', res.message )
                    }

                    ndis.removeLoader( elm );
                }
        );

    }


    

    /**
    **  Function that will load the Participant details when a Participant is selected from the drop down
    **  @argument elm jQuery object for an Element
    **  @argument data Object to send in POST
    **/
    function loadRegGrpItems(elm, elVal){
        ndis.addLoader( elm );
        ndis.ajax(
                '{{ route("admin.bookings.registration.items") }}',
                'POST',
                { parentId : elVal },
                function(res){
                    if(res.success){
                        jQuery("#dm-item_number").replaceWith( res.result.regItemsDDHTML )
                    }
                    if(res.error){
                        ndis.displayMsg( 'error', res.msg)
                    }
                    ndis.removeLoader( elm );
                }
            );
    }


    jQuery(document).ready(function(ev){

            

            jQuery('#serviceFrm').on('change', '#participant', function (ev) {

                is_dirty = true;
                
                elm = jQuery(this);
                elId = elm.attr('id');
                elVal = elm.val();
                if(elVal)
                    loadParticipantDetails(elm);

                formOperations("swbooking");

                if( jQuery('.service_type').filter(':checked').val() == 'external_service' ){

                    jQuery('#dm-item_number').css({'padding-left':'0.5%','padding-right':'3%'});
                }else{
                    jQuery('#dm-item_number').css({'padding-left':'3%','padding-right':'0%'});
                }

            });
            
            jQuery('#serviceFrm').on('change', '#registration_group_id', function (ev) {

                is_dirty = true;
                
                elm = jQuery(this);
                elId = elm.attr('id');
                elVal = elm.val();

                //Load Registration Items for Parent
                if(elVal)
                    loadRegGrpItems(elm, elVal);
            
                formOperations("swbooking");

                if( jQuery('.service_type').filter(':checked').val() == 'external_service' ){
                    jQuery('#dm-item_number').css({'padding-left':'0.5%','padding-right':'3%'});
                }else{
                    jQuery('#dm-item_number').css({'padding-left':'3%','padding-right':'0%'});
                }
                
            });


            jQuery('#serviceFrm').on('focus', '#dt-date', function (ev) {
                userAvailabilityMsgShown = false;
            });
            jQuery('#serviceFrm').on('focus', '#dt-start_time', function (ev) {
                if(!userAvailabilityMsgShown){
                    dateSelected = $("#dt-date").val();
                    if(ndis.isValidDate(dateSelected)){
                        var dayNum = moment(dateSelected).day();
                        if(undefined !== userAvailability[dayNum]){
                            var timeSlots = [];
                            userAvailability[dayNum].forEach(function(slot) {
                                timeSlots.push ( " ("+slot.from+" : "+slot.to+") " );
                            });
                            var timeSlotMsg = "Participant only available between "+timeSlots.join(' , ');
                            ndis.showToast("Participant Time Availability", timeSlotMsg);
                        }
                    }
                    userAvailabilityMsgShown = true;
                }
                
            });


            jQuery('#serviceFrm').on('blur', '#inp-location, #dt-date, #dt-start_time, #dt-end_time', function (ev) {
                var formId = "swbooking";
                var bookingDate = jQuery("#"+formId+" #dt-date").val();
                var bookingStart = jQuery("#"+formId+" #dt-start_time").val();
                var bookingEnd = jQuery("#"+formId+" #dt-end_time").val();
                if( 
                    !ndis.isEmpty( bookingDate ) && 
                    !ndis.isEmpty( bookingStart ) && 
                    !ndis.isEmpty( bookingEnd )
                ){
                    if(! moment( bookingStart,  'h:mm a').isBefore(moment( bookingEnd,  'h:mm a')) ){
                        ndis.displayMsg( 'error', 'Booking start time should be less than the end time');
                        return;
                    }else{
                        formOperations("swbooking");
                    }
                }
            });

            // jQuery('#serviceFrm').on('input', '#dt-date', function (ev) {
            //     is_dirty = true;
            //     ev.preventDefault();
            //     var formData = {
            //         'service_type': jQuery("#swbooking").attr('data-type'),
            //         'participant_id': jQuery("#participant").val(),
            //         'date': jQuery(this).val()
            //     };

            //     ndis.ajax(
            //             '{{ route("admin.bookings.participant.availability.time") }}',
            //             'POST',
            //             formData,
            //             function(res){
            //                 if(res.status){
            //                     ndis.displayMsg( 'success', res.message);
            //                     ndis.redirect('{{ route("admin.bookings.index") }}')
            //                 }
            //                 else{
            //                     ndis.displayMsg( 'error', res.message)
            //                 }
            //                 ndis.removeButtonLoader( jQuery('#serviceFrm') );
            //             }
            //         );
            // });

            
            // jQuery('#serviceFrm').on('input', 'input', function (ev) {
            //     is_dirty = true;
            //     ev.preventDefault();
            //     formOperations("swbooking");
            // });

            // jQuery('#serviceFrm').on('input', '#dt-date, #dt-start_time, #dt-end_time', function (ev) {
            //     var participant_id = jQuery("#swbooking #participant").val();
            //     var bookingDate = jQuery("#swbooking #dt-date").val();
            //     var bookingStart = jQuery("#swbooking #dt-start_time").val();
            //     var bookingEnd = jQuery("#swbooking #dt-end_time").val();
            // });
            
            
            if($('#service_type_selector').length && jQuery("#participant").val() != ""){
                    jQuery("#participant").trigger('change');
            }
            
            var service_types = jQuery('.service_type').change(function () {
                console.log('yes');
                jQuery("#swbooking").attr('data-type', service_types.filter(':checked').val());
                if(service_types.filter(':checked').val() == 'external_service'){
                    jQuery("#dm-supp_wrkr_ext_serv_id").find("label").text( "{{trans('bookings.fields.ext_service_provider')}}" )
                    jQuery('#dm-inp-location').hide();
                    jQuery('#start-end-time, #dm-item_number, #dm-is_recurring').css({'padding-left':'0.5%','padding-right':'3%'});
                }else{
                    jQuery("#dm-supp_wrkr_ext_serv_id").find("label").text( "{{trans('bookings.fields.support_worker')}}" )
                    jQuery('#dm-inp-location').show();
                    jQuery('#start-end-time, #dm-item_number, #dm-is_recurring').css({'padding-left':'3%','padding-right':'0%'});
                }

                if(jQuery("#participant").val() != ""){
                    jQuery("#participant").trigger('change');
                }

            });

            jQuery("#is_recurring").on('change', function(ev){
                if( parseInt(jQuery(this).val()) ){
                    jQuery("#recurringFields").show();
                }else{
                    jQuery("#recurringFields").hide();
                }
            })
           

            //---------------------------------------------------------------------------------------------


            /**
            **  Ajax function that binds the submit buttons for the Booking request
            **/
            jQuery('#serviceFrm').on('click', '#saveBooking', function (ev) {
                
                var formData = jQuery('#serviceFrm form').serialize();
                ndis.addButtonLoader( jQuery('#serviceFrm') );
                ndis.ajax(
                        '{{ route("admin.bookings.store") }}',
                        'POST',
                        formData,
                        function(res){
                            if(res.status){
                                ndis.displayMsg( 'success', res.message);
                                ndis.redirect('{{ route("admin.bookings.index") }}')
                            }
                            else{
                                ndis.displayMsg( 'error', res.message)
                            }
                            ndis.removeButtonLoader( jQuery('#serviceFrm') );
                        }
                    );

            });

            
    });


</script>

@endsection