<input type="hidden" id="user_id" name="user_id" class="form-control" value="{{ old('user_id', isset($participant) ? $participant->user_id : 0) }}" />

<div>

   

    <div class="participant-opforms form-mt">
            <div class="card-header">
                {{ trans('participants.fields.opforms_title') }}
            </div>
        <div class="table-responsive">
            <div class="card-body mt-2">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover datatable">
                        <thead>
                            <tr>
                                <th>
                                    No
                                </th>
                                <th>
                                    Title 
                                </th>
                                <th>
                                    Date
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($opforms as $key => $form)
                                <tr data-entry-id="{{ $form->id }}">
                                    <td>
                                        <a href="{{ route('admin.forms.edit', [$form->id, $isParticipantTrue=1]) }}">{{ $key + 1 }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.forms.edit', [$form->id, $isParticipantTrue=1 ]) }}">{{ $form->optitle }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.forms.edit', [$form->id, $isParticipantTrue=1]) }}">{{ $form->date }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

     <div class="participant-document form-mt">

        <div class="table-responsive">

            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <!--  <th width="10"></th> -->
                        <th scope="col">{{ trans('participants.tabs.table_no') }}</th>
                        <th scope="col">{{ trans('participants.tabs.document_date') }}</th>
                        <th scope="col">{{ trans('participants.tabs.upload_date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if( count($participant->documents) )
                    @foreach($participant->documents as $key => $document)
                        
                <tr data-entry-id="{{ $document->id }}" >
                            <td>
                                {{ $key + 1 }}
                            </td>
                            <td>
                                <a target="_blank" href="{{$document->url}}">{{ slug_to_human($document->title ?? '') }}</a>
                            </td>
                            <td>
                                <a target="_blank" href="{{$document->url}}">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',  $document->created_at)->format( config('app.date') ) }}</a>
                            </td>
                            
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="12" class="text-center">
                                No Records Found!
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

        </div>

        <div class="upload-document">
            <a href="{{ route("admin.participants.documents.new", [$participant->user_id]) }}">
            <button class="btn btn-secondary rounded plr-100 mt-20" type="button">
                {{ trans('documents.upload_new') }} 
                <i class="fa fa-upload" aria-hidden="true"></i>
            </button>
            </a>
        </div>

    </div>

</div>
