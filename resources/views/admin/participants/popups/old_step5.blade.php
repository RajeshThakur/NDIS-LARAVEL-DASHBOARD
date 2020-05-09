@if ($modal_id = 'step5') @endif
<div class="modal micromodal-slide" id="{{$modal_id}}" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1">
        <div class="modal__container w-90 w-40-ns" role="dialog" aria-modal="true" aria-labelledby="{{$modal_id}}-title">

            <form class="black-80 onboarding" id="form_{{$modal_id}}" action="/">

                <header class="modal__header ">
                    <button class="modal__close js-modal-close-trigger" aria-label="Close modal" data-custom-close></button>    
                    <h2 class="modal__title">{{ trans('participants.onboarding.title.step5') }}</h2>
                </header>
            <div class="main-column">
                <div class="modal__content" id="{{$modal_id}}-content">
                    
                    {!! 
                        Form::text('guardian_email', trans('global.user.fields.email'))->id('guardian_email')->required('required')
                    !!}


                    {!! 
                        Form::password('guardian_password', trans('global.user.fields.password'))->id('guardian_password')->required('required')
                    !!}

                    {!! 
                        Form::password('guardian_password_confirmation', trans('global.user.fields.confirm_password'))->id('guardian_password_confirmation')->required('required')
                    !!}

                </div>

                <input type="hidden" name="user_id" value="{{$participant->user_id}}" />
                <input type="hidden" name="step" value="5" />

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