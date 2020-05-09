<form action="{{ route("admin.support-workers.notes.save", [$supportWorker->user_id]) }}" method="POST" class="validated" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" id="user_id" name="user_id" class="form-control" value="{{ old('user_id', isset($supportWorker) ? $supportWorker->user_id : 0) }}" />
        {{-- <input type="hidden" id="support_worker_id" name="support_worker_id" class="form-control" value="{{ old('support_worker_id', isset($supportWorker) ? $supportWorker->user->support_worker_id : 0) }}" /> --}}
        <div class="booking-document form-mt">
            <div class="row">


                {!! 
                    Form::text('title', trans('sw.tabs.topic') )
                    ->placeholder('Enter topic Name')
                    ->id("title")
                    ->size('col-sm-6')
                    ->attrs([
                        "required"=>"required",
                        "data-rule-required"=>"true",
                        "data-msg-required"=>trans('errors.support_worker_notes.topic')
                    ])
                !!}


                {!! 
                    Form::text('description', trans('sw.tabs.note_desc'))
                    ->placeholder( "Enter Topic Description" )
                    ->id("description")
                    ->size('col-sm-6')
                    ->attrs([
                        "required"=>"required",
                        "data-rule-required"=>"true",
                        "data-msg-required"=>trans('errors.support_worker_notes.note_description')
                    ])
                !!}

                <div class="create-new edit-new participant-notes col-sm-12">

                    {!! 
                        Form::submit(trans('global.save'))->attrs(["class"=>"btn btn-primary plr-100 rounded"]) 
                    !!}

                    {!! 
                        Form::submit(trans('sw.tabs.create_note'))->attrs(["class"=>"btn btn-primary  ml-30 rounded"]) 
                    !!}

                {{-- <div class="create-new edit-new participant-notes">
                    <input class="btn btn-success cyan-blue-bg plr-100" type="submit" value="{{ trans('global.save') }}">
                    <input class="btn btn-success blue-bg ml-30" type="submit" value="{{ trans('sw.tabs.create_note') }}">
                </div> --}}
                
            </div>

            
        </div>

  
</form>


<div class="participant-document form-mt">
    <div class="table-responsive">
        <table class="table datatable">
            <thead>
                <tr>
                    <th scope="col">{{ trans('sw.tabs.table_no') }}</th>
                    <th scope="col">{{ trans('sw.tabs.topic') }}</th>
                    <th scope="col">{{ trans('sw.tabs.created_date') }}</th>
                </tr>
            </thead>
            <tbody>
                @if( count($supportWorker->notes) )
                @foreach($supportWorker->notes as $key => $note)
                    <tr data-entry-id="{{ $note->id }}">
                        <td>
                            {{ $key+1 ?? '' }}
                        </td>
                        <td>
                            {{ $note->title ?? '' }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',  $note->created_at)->format( config('app.date') ) }}
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