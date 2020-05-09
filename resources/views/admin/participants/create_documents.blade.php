<form action="{{ route("admin.participants.documents.save", [$participant->user_id]) }}" method="POST" class="validated" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <input type="hidden" id="user_id" name="user_id" class="form-control" value="{{ old('user_id', isset($participant) ? $participant->user_id : 0) }}" />
            <input type="hidden" id="provider_id" name="provider_id" class="form-control" value="{{ old('provider_id', isset($participant) ? $participant->user->provider_id : 0) }}" />
            
            <div class="participant-document form-mt">
                <div class="row">

                    {!! 
                        Form::text('title', trans('documents.fields.title'), old('title', isset($participant) ? $participant->title : ''))
                        ->id('title')
                        ->size('col-sm-6')
                        ->help(trans('documents.fields.title_helper')) 
                        ->attrs([
                            "required"=>"required",
                            "data-rule-required"=>"true",
                            "data-msg-required"=>trans('errors.participant_add_new_document.title')
                        ])
                    !!}

                    {!! 
                        Form::file('document', trans('documents.fields.document'))
                        ->id('document')
                        ->size('col-sm-6')
                        ->help(trans('documents.fields.document_helper'))
                        ->attrs([
                            "required"=>"required",
                            "data-rule-required"=>"true",
                            "data-msg-required"=>trans('errors.participant_add_new_document.document')
                        ])
                    !!}  

                </div>    
            </div>
            {!! 
                Form::submit(trans('global.save'))->attrs(["class"=>"btn btn-sucess rounded"]) 
            !!}
        </div>
    </form>