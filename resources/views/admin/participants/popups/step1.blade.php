@if ($modal_id = 'step1') @endif
<div class="modal micromodal-slide" id="{{$modal_id}}" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" >
        <div class="modal__container w-90 w-40-ns" role="dialog" aria-modal="true" aria-labelledby="{{$modal_id}}-title">

            <form class="black-80 onboarding" id="form_{{$modal_id}}" action="">
                @csrf
                <header class="modal__header">
                    <button class="modal__close modal-close-trigger" aria-label="Close modal" data-custom-close></button>
                    <h2 class="modal__title">{{ trans('participants.onboarding.title.step1') }}</h2>
                </header>
                <div class="main-column">
                    <div class="modal__content" id="{{$modal_id}}-content">
                        
                        <div class="row">
                            
                            {!! 
                                Form::select('have_gps_phone', trans('participants.onboarding.fields.gps_phone'),  array('1' => 'Yes', '0' => 'No'))->required('required')
                            !!}

                            {!! 
                                Form::select('using_guardian', trans('participants.onboarding.fields.have_guardian'),  array('1' => 'Yes', '0' => 'No'))->required('required')
                            !!}

                            
                        </div>

                    </div>

                    <input type="hidden" name="user_id" value="{{$participant->user_id}}" />
                    <input type="hidden" name="step" value="1" />

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