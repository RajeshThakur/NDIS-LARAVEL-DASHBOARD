@if ($modal_id = 'step3') @endif
<div class="modal micromodal-slide" id="{{$modal_id}}" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1">
        <div class="modal__container w-90 w-40-ns" role="dialog" aria-modal="true" aria-labelledby="{{$modal_id}}-title">

            <form class="black-80 onboarding" action="/">

                <header class="modal__header">
                    <button class="modal__close" aria-label="Close modal" data-custom-close></button>
                    <h2 class="modal__title">{{ trans('participants.onboarding.title.step3') }}</h2>
                </header>
            <div class="main-column upload-documentaion">
                <div class="modal__content" id="{{$modal_id}}-content">
                    
                    <div class="row">
                        <div class="col-sm-4 custom-pdr">
                            <div class="file-upload upload-document-popup">
                                <div class="file-select">
                                    <div class="file-select-name" id="careplan">
                                    <a href="{{ route("admin.forms.create", [2, $participant->user_id, $isParticipantTrue=1]) }}" ><p>Care Plan</p></a>
                                    @if (isset($operationFormFill['care_plan']))
                                        <span class="opform_cheked">&#10004;</span>
                                    @endif
                                        <div class="form-check-inline" id="care_plan_result"></div>
                                    </div>                                     
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 custom-pdr">
                            <div class="file-upload upload-document-popup risk-assesment">
                                <div class="file-select">
                                    <div class="file-select-name" id="risk_assessment">
                                        <a href="{{ route("admin.forms.create", [10, $participant->user_id,$isParticipantTrue=1]) }}"><p>Risk Assessment</p></a>
                                        @if (isset($operationFormFill['risk_assessment']))
                                            <span class="opform_cheked">&#10004;</span>
                                        @endif
                                        <div class="form-check-inline" id="risk_assesment_result"></div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="file-upload upload-document-popup client-consent-form">
                                <div class="file-select">
                                    <div class="file-select-name" id="client_consent_form">
                                        <a href="{{ route("admin.forms.create", [3, $participant->user_id, $isParticipantTrue=1]) }}"><p>Client Consent Form</p></a>
                                        @if (isset($operationFormFill['client_consent_form']))
                                            <span class="opform_cheked">&#10004;</span>
                                        @endif
                                        <div class="form-check-inline" id="consent_form_result"></div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <input type="hidden" name="user_id" value="{{$participant->user_id}}" />
                <input type="hidden" name="step" value="3" />

                <footer class="modal__footer">
                    <button class="btn btn-success pl-6 pr-6 submitter" type="submit" >
                        {{ trans('participants.onboarding.button.next') }}
                    </button>
                </footer>
            </div>

            </form>
        </div>
    </div>
</div>



@section('scripts')
@parent
<script>
   jQuery(document).ready(function(){

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $('#avatar-tag').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function enableSubmitButton(){
            
            var isValid = true;

            if( jQuery("#care_plan_id").val() == '' )
                isValid = false;
            
            if( jQuery("#risk_assesment_id").val() == '' )
                isValid = false;

            if( jQuery("#consent_form_id").val() == '' )
                isValid = false;

            if(isValid)
                jQuery("button.submitter").removeAttr('disabled');
            else
                jQuery("button.submitter").attr('disabled','disabled');
            

        }

        $("#care_plan, #risk_assesment, #consent_form").change(function( e ){
            // readURL(this);           
            // $('#avatar-upload').prop("disabled", false);
            var elementId = jQuery(this).attr('id');
            var file_data = $('#'+elementId).prop('files')[0];
            var form_data = new FormData();
            form_data.append('title', elementId);
            form_data.append('file', file_data);
            form_data.append('user_id', {{$participant->user_id}} );
            
            //Add Spinner
            $("#"+elementId+"_result").html('<i class="fa fa-circle-o-notch loader" aria-hidden="true"></i>');

            var request = $.ajax({
                                url:'{{ route("admin.documents.save") }}',
                                method: "POST",
                                data:  form_data,
                                enctype: 'multipart/form-data',
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                processData: false,  // Important!
                                contentType: false,
                                cache: false,
                            });
            
            request.done(function( response ) {

                if(response.success){
                    $("#"+elementId+"_id").val(response.id);
                    $("#"+elementId+"_result").html('<i class="fa fa-check" aria-hidden="true"></i>');
                    enableSubmitButton();
                }else{
                    $("#"+elementId+"_result").html('<i class="fa fa-times" aria-hidden="true"></i>');
                }
            });
            
            request.fail(function( jqXHR, textStatus ) {
                console.log(textStatus);
            });

        });
    
   });
</script>
@endsection