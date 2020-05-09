
<div>

    <div class="participant-document form-mt">

{{-- 
            <div class="jumbotron" id="onboard-message">            
                <div class="col-lg-12">
                    <h3 classs="alert-heading">{{$supportWorker->linked_participants}}</h3>
                    <hr class="my-4">                                
                </div> 
            </div> --}}

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>
                            No 
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Address
                        </th>                            
                        <th>
                            Mobile Number
                        </th>
                        
                    </tr>
                </thead>
                <tbody>
                    @if( count($supportWorker->linked_participants) )
                    <?php $i = 1; ?> 
                    @foreach($supportWorker->linked_participants as $key => $booking)
                        <tr data-entry-id="{{ $booking->participant_id }}">
                            <td>
                                {{ $i }}
                            </td>
                            <td>
                                <a class="" href="{{ route('admin.participants.edit', $booking->participants_details_id) }}">
                                    {{ $booking->participant_fname  ?? '' }}
                                    {{ $booking->participant_lname ?? '' }}
                                </a>
                            </td>
                            <td>
                                {{ $booking->booking_location }}
                            </td>
                            <td>
                                {{ $booking->participant_mobile }}
                            </td>                           
                        </tr>
                        <?php $i++; ?>
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
    