
<div class="participant-document form-mt">
    <div class="table-responsive">
    
            <table class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10" class="select-checkbox sorting_disabled" rowspan="1" colspan="1" style="width: 10px;" aria-label=""></th>
                        <th scope="col">{{ trans('participants.tabs.table_no') }}</th>
                        <th scope="col">{{ trans('global.messages') }}</th>
                        <th scope="col">{{ trans('global.sender') }}</th>
                        <th scope="col">{{ trans('participants.tabs.created_date') }}</th>
                        <th width="10" class="select-checkbox sorting_disabled" rowspan="1" colspan="1" style="width: 10px;" aria-label=""></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($bookingOrder->messages))
                        @foreach($bookingOrder->messages as $key => $message)
                            <tr data-entry-id="{{$message->id}}">
                                <td width="10" class="select-checkbox sorting_disabled" rowspan="1" colspan="1" style="width: 10px;" aria-label=""></td>
                                <td>
                                    {{ $key+1 ?? '' }}
                                </td>
                                <td>
                                    {{ $message->body ?? '' }}
                                </td>
                                <td>
                                    {{ $message->sender ?? '' }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',  $message->created_at)->format( config('app.date') ) }}
                                </td>
                                <td width="10" class="select-checkbox sorting_disabled" rowspan="1" colspan="1" style="width: 10px;" aria-label=""></td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td width="10" class="select-checkbox sorting_disabled" rowspan="1" colspan="1" style="width: 10px;" aria-label=""></td>
                            <td colspan="4">
                                No Messages For Participants Yet!
                            </td>
                            <td width="10" class="select-checkbox sorting_disabled" rowspan="1" colspan="1" style="width: 10px;" aria-label=""></td>
                        </tr>
                    @endif
    
                    
                </tbody>
            </table>


            {!! 
                Form::button( trans('global.messaging.create_new'), 'primary')->attrs(["class"=>"rounded plr-100 mt-2"])->id('newMessage') 
            !!}
    
    </div>
</div>
    
<div id="newMsgForm" style="display:none;">

    <form action="{{ route("admin.bookings.edit.contact.participant.save", [$bookingOrder->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <h4>{{trans('global.messaging.create_new')}}</h4>
    
        <div class="booking-document form-mt">
            <div class="row">
    
                <!-- Message Form Input -->
                {!! 
                    Form::textarea('message',  'Message', old('message') )->placeholder('Type Your Message Here....')
                !!}
                <div class="create-new">
                    {!! 
                        Form::submit(trans('global.send'), 'success')->attrs(["class"=>"btn btn-primary rounded plr-100"]) 
                    !!}
                </div>
            </div>
        </div>
    </form>
    
</div>



@section('scripts')
@parent
<script>
$(function () {
    jQuery("#newMessage").on('click', function(ev){
        jQuery(this).hide();
        jQuery("#newMsgForm").show();
    })
})

</script>
@endsection