
@section('bottom')
    @parent
    <div id="onboardingForms">
        @include( 'admin.supportWorkers.popups.step1' )
        @include( 'admin.supportWorkers.popups.step2' )
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        $(function () {
            
            var is_popup_closed = localStorage.getItem("is_popup_closed");

            if(!is_popup_closed){
                
                var current_step = {{$supportWorker->onboarding_step}};

                if(!current_step)
                    current_step = 1;

                var form,
                    previous_step = null;


                function proessResponse( data ){
                    
                    if(data.type == 'popup'){
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
                
                // Validate Steps
                ndis.ajax(
                    '{{ route("admin.support-workers.onboarding.validate") }}',
                    'POST',
                    {
                        'user_id': jQuery("#user_id").val()
                    },
                    function(data) {
                        // On Success
                        if( data.status ){
                            proessResponse(data);
                        }
                        else {
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
                    
                    ndis.ajax(
                        '{{ route("admin.support-workers.steps") }}',
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


                });
            }

        })

    </script>

@endsection