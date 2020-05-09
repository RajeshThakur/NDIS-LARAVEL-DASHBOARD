@if ($modal_id = 'step2') @endif
<div class="modal micromodal-slide" id="{{$modal_id}}" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1">
        <div class="modal__container w-90 w-40-ns" role="dialog" aria-modal="true" aria-labelledby="{{$modal_id}}-title">

            <form class="black-80 onboarding" id="form_{{$modal_id}}" action="/">

                <header class="modal__header ">
                    <button class="modal__close js-modal-close-trigger" aria-label="Close modal" data-custom-close></button>    
                    
                </header>
                <div class="modal__content" id="{{$modal_id}}-content">
                    <h2 class="modal__title">Thank You for signing the agreement. Please click ‘Finish’ button to complete the Onboarding Process.</h2>
                </div>
            <div class="main-column">
                

                <input type="hidden" name="user_id" id="user_id" value="{{$serviceProvider->user_id}}">
                <input type="hidden" name="step" value="2" />

                <footer class="modal__footer">
                    <button class="btn btn-success pl-6 pr-6 submitter" type="submit" >
                        {{ trans('participants.onboarding.button.finish') }}
                    </button>
                </footer>
            </div>

            </form>
        </div>
    </div>
</div>