
@section('bottom')
    @parent
    <div id="onboardingForms">
        @include( 'admin.participants.popups.step1' )
        @include( 'admin.participants.popups.step2' )
        @include( 'admin.participants.popups.step3' )
        @include( 'admin.participants.popups.step4' )
        {{-- @include( 'admin.participants.popups.step5' ) --}}
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        $(function () {
            
            var is_popup_closed = localStorage.getItem("is_popup_closed");

            if(!is_popup_closed){

                var current_step = {{$participant->onboarding_step}};

                if(!current_step)
                    current_step = 1;

                var form,
                    previous_step = null;


                function proessResponse( data ){
                    
                    if(data.type == 'popup'){

                        if(data.operationFormFill){
                            $.each(data.operationFormFill,function(key,value){

                                if(key == 'care_plan' && value){
                                    $('#care_plan_result').append('<span class="opform_cheked">&#10004;</span>');
                                }

                                if(key == 'risk_assessment' && value){
                                    $('#risk_assesment_result').append('<span class="opform_cheked">&#10004;</span>');
                                }

                                if(key == 'client_consent_form' && value){
                                    $('#consent_form_result').append('<span class="opform_cheked">&#10004;</span>');
                                }
                                
                            })
                        }

                        ndis.closePopup('step'+previous_step);
                        ndis.popup( 'step'+data.next_step );
                    }
                    else if(data.type == 'redirect'){
                        ndis.redirect(data.redirect_url);
                    }
                    else if(data.type == 'finish'){
                        ndis.closePopup('step'+previous_step);
                    }
                }

                //Validate Onboarding Step and Open PopUp
                // ndis.popup( 'step' + current_step );
                // Validate Steps
                ndis.ajax(
                    '{{ route("admin.participants.onboarding.validate") }}',
                    'POST',
                    {
                        'user_id': jQuery("#user_id").val()
                    },
                    function(data) {
                        // On Success
                        console.log(data);
                        if( data.status ){
                            proessResponse(data);
                        }
                        else {
                            console.log( "msg", data )
                            form.find(".modal__content").prepend( ndis.error( data.message ) )
                        }

                    },
                    function(jqXHR, textStatus) {
                        form.find(".modal__content").prepend( ndis.error( jqXHR.responseJSON.message ) )
                    }
                );

                jQuery("#onboardingForms").on('click', ".modal-close-trigger", function(ev){
                    ev.preventDefault();
                    localStorage.setItem("is_popup_closed", 1);
                });

                jQuery("#onboardingForms").on('click', "form.onboarding .submitter", function(ev){

                    ev.preventDefault();

                    form = jQuery(this).closest('form');
                    previous_step = form.find('input[name="step"]').val();

                    formData = form.serialize();
                    console.log(formData)
                    
                    // url:'{{ route("api.participants.onboarding") }}',
                    ndis.ajax(
                        '{{ route("admin.participants.steps") }}',
                        'POST',
                        formData,
                        function(data) {
                            // On Success
                            if( data.status ){
                                proessResponse(data);
                            }
                            else {
                                console.log( "msg", data.message )
                                form.find(".modal__content").prepend( ndis.error( data.message ) )
                            }

                        },
                        function(jqXHR, textStatus) {
                            form.find(".modal__content").prepend( ndis.error( jqXHR.responseJSON.message ) )
                        }
                    );


                    // var request = jQuery.ajax({
                    //                         // url:'{{ route("api.participants.onboarding") }}',
                    //                         type: "POST",
                    //                         data: formData,
                    //                         dataType: "json"
                    //                     });

                    // request.done();

                    // request.fail();


                });

            }
            
            


        })

    </script>

@endsection