<form action="{{ route("admin.support-workers.documents.save", [$supportWorker->user_id]) }}" method="POST" class="validated" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <input type="hidden" id="user_id" name="user_id" class="form-control" value="{{ old('user_id', isset($supportWorker) ? $supportWorker->user_id : 0) }}" />
            <input type="hidden" id="provider_id" name="provider_id" class="form-control" value="{{ old('provider_id', isset($supportWorker) ? $supportWorker->user->provider_id : 0) }}" />
            
            <div class="participant-document form-mt">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="participent-one-form">
                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            <label for="title">{{ trans('documents.fields.title') }}*</label>
                            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($supportWorker) ? $supportWorker->title : '') }}" required="required">
                           
                            <p class="helper-block">
                                {{ trans('documents.fields.title_helper') }}
                            </p>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="participent-two-form">
                            <div class="form-group {{ $errors->has('document') ? 'has-error' : '' }}">
                            <label for="document">{{ trans('documents.fields.document') }}*</label>

                                <label for="custom-file-upload" class="filupp">
                                    <span class="filupp-file-name js-value">Browse Files</span>
                                    <input type="file" name="document" id="document" class="filecontrol form-control" required="required">
                                </label> 
                            
                           
                            <p class="helper-block">
                                {{ trans('documents.fields.document_helper') }}
                            </p>
                        </div>
                        </div>
                    </div>    
                </div>    
            </div>
            <input class="btn btn-secondary rounded" type="submit" value="{{ trans('global.save') }}">
        </div>
    </form>