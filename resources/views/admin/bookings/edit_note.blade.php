<form action="{{ route("admin.bookings.edit.note.save", [$booking->order_id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" id="booking_id" name="booking_id" class="form-control" value="{{ old('booking_id', isset($booking) ? $booking->id : 0) }}" />
        <div class="booking-document form-mt">
            <div class="row">

                {!!
                    Form::textarea('description', trans('participants.tabs.note_desc'))
                            ->id('description')
                            ->size('col-sm-12')
                            ->hideLabel()
                !!}

                <div class="create-new edit-new participant-notes col-sm-12">

                    {!! 
                        Form::submit(trans('global.save'), 'primary')->attrs(["class"=>"btn btn-primary rounded plr-100"]) 
                    !!}

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
                        <th width="10" class="select-checkbox sorting_disabled" rowspan="1" colspan="1" style="width: 10px;" aria-label=""></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($booking->notes as $key => $note)

                        <tr data-entry-id="{{$note->id}}">
                            <td width="10" class="select-checkbox sorting_disabled" rowspan="1" colspan="1" style="width: 10px;" aria-label=""></td>
                            <td>
                                {{ $key+1 ?? '' }}
                            </td>
                            <td>
                                {{ $note->description ?? '' }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',  $note->created_at)->format( config('app.date') ) }}
                            </td>
                            <td width="10" class="select-checkbox sorting_disabled" rowspan="1" colspan="1" style="width: 10px;" aria-label=""></td>
                        </tr>
                    @endforeach

                    
                </tbody>
            </table>

    </div>
</div>



@section('scripts')
@parent
<script>
    $(function () {
    })

</script>
@endsection