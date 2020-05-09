@if ($modal_id = 'step1') @endif
<div class="modal micromodal-slide" id="{{$modal_id}}" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" >
        <div class="modal__container w-90 w-40-ns" role="dialog" aria-modal="true" aria-labelledby="{{$modal_id}}-title">

            <form class="black-80 onboarding" id="form_step1" action="/">

                <header class="modal__header">
                    
                    <button class="modal__close" aria-label="Close modal" data-custom-close=""></button>
                    <h2 class="modal__title">Do you want to sign the Provider Agreement with the Worker now?</h2>
                </header>
            <div class="main-column">
                <div class="modal__content" id="step2-content">
                    <div class="row">  
                        <div id="dm-inp-provider_agreement" class="col-sm-12">
                            {{-- <div class="form-group">
                                <label for="inp-provider_agreement" class="">Sign Worker Agreement? *</label>
                                <div class="input-group">
                                    <select name="provider_agreement" id="inp-provider_agreement" class="form-control" required="required">
                                        <option value="1">Yes</option>
                                        <option value="0" selected="">No</option>
                                    </select>
                                    <i class="inputicon fa fa-caret-down" aria-hidden="true"></i>
                                </div>
                                <small class="form-text text-muted">&nbsp;</small>
                            </div> --}}
                        </div>
                    </div>
                </div>

                <input type="hidden" name="user_id" value="{{$supportWorker->user_id}}">
                <input type="hidden" name="step" value="1">
                <input type="hidden" name="provider_agreement" value="1">

                <footer class="modal__footer inline-box">
                    <button class="btn btn-success pl-5 pr-5 submitter" type="submit">
                        Yes
                    </button>

                    <button class="btn btn-success pl-5 pr-5" data-custom-close="" type="submit">
                        No
                    </button>
                </footer>
            </div>

            </form>
        </div>
    </div>
</div>