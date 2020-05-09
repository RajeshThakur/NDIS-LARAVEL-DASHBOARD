<form action="{{ route("admin.participants.notes.save", [$participant->user_id]) }}" method="POST" class="validated" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" id="user_id" name="user_id" class="form-control" value="{{ old('user_id', isset($participant) ? $participant->user_id : 0) }}" />
        <div class="booking-document form-mt">
            <div class="row">

                {!! 
                    Form::text('title', trans('participants.tabs.topic') )
                    ->id('title')
                    ->size('col-sm-6')
                    ->attrs([
                        "required"=>"required",
                        "data-rule-required"=>"true",
                        "data-msg-required"=>trans('errors.participant_notes.topic')
                    ])
                !!}

                {!! 
                    Form::text('description', trans('participants.tabs.note_desc') )
                    ->id('description')
                    ->size('col-sm-6')
                    ->attrs([
                        "required"=>"required",
                        "data-rule-required"=>"true",
                        "data-msg-required"=>trans('errors.participant_notes.note_description')
                    ])
                !!}

                <div class="create-new edit-new participant-notes col-sm-12">

                    {!! 
                        Form::submit(trans('global.save'))->attrs(["class"=>"btn btn-primary rounded plr-100"]) 
                    !!}

                    {{-- {!! 
                        Form::submit(trans('participants.tabs.create_note'))->attrs(["class"=>"btn btn-primary rounded ml-30"]) 
                    !!} --}}

                </div>
            </div>

        </div>

</form>


<div class="participant-document form-mt">
    <div class="table-responsive">

            <table class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10" class="select-checkbox sorting_disabled" rowspan="1" colspan="1" style="width: 10px;" aria-label=""></th>
                        <th scope="col">{{ trans('participants.tabs.table_no') }}</th>
                        <th scope="col">{{ trans('participants.tabs.notes') }}</th>
                        <th scope="col">{{ trans('participants.tabs.created_date') }}</th>
                        {{-- <th width="10" class="select-checkbox sorting_disabled" rowspan="1" colspan="1" style="width: 10px;" aria-label=""></th> --}}
                    </tr>
                </thead>
                <tbody>
                    @if( count($participant->notes) )
                    @foreach($participant->notes as $key => $note)
                        <tr data-entry-id="{{ $note->id }}">
                            <td width="10" class="select-checkbox sorting_disabled" rowspan="1" colspan="1" style="width: 10px;" aria-label=""></td>
                            <td>
                                {{ $key+1 ?? '' }}
                            </td>
                            <td>
                                {{ $note->title ?? '' }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',  $note->created_at)->format( config('app.date') ) }}
                            </td>
                            {{-- <td width="10" class="select-checkbox sorting_disabled" rowspan="1" colspan="1" style="width: 10px;" aria-label=""></td> --}}
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
</div>



@section('scripts')
@parent
<script>
    $(function () {

        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons });
       
    })

</script>
@endsection