
<form action="#" method="POST" enctype="multipart/form-data">

    @csrf

    @method('PUT')

    <div class="card-body mt-2">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>
                            No
                        </th>
                        <th>
                            Participant Name
                        </th>
                        <th>
                            Total Hours
                        </th>                            
                        <th>
                            Amount to billed for this Participant
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $totalTime = 0;
                        $totalAmount = 0;
                    ?>

                    @foreach($timeSheet as $key => $sheet)
                        
                            <tr data-entry-id="{{ $sheet->id }}">

                            @if($key+1 >= 10)
                                <td>    
                                    <a href="#">{{ $key+1 }}</a>
                                </td>
                            @else
                                <td>    
                                    <a href="#">0{{ $key+1 }}</a>
                                </td>
                            @endif
                                

                                <td>    
                                    <a href="#">{{ $sheet->participant_name }}</a>
                                </td>

                                <td>    
                                    <a href="#">{{ $sheet->total_time }}</a>
                                    <?php $totalTime += $sheet->total_time; ?>
                                </td>

                                <td>    
                                    <a href="#">${{ $sheet->total_amount }}</a>
                                    <?php $totalAmount += $sheet->total_amount; ?>
                                </td>

                            </tr>
                        
                    @endforeach
                </tbody>

            </table>

            @if($totalAmount != 0 && $totalTime != 0)
            <div class="d-flex justify-content-end">
                <div class="proda-totals">
                    
                    <p>Total Hours for All Service Bookings:<span>{{ $totalTime }}</span></p>
                    <p>Total Amount:<span>${{ $totalAmount }}</span></p>
                </div>
            </div>
            @endif
            
        </div>

        

    </div>

    {{-- {!! 
        Form::submit('Paid')->attrs(["class"=>"btn btn-primary rounded ml-30"]) 
    !!} --}}
</form>

<div class="account-sub-button">
    <div class="create-new edit-new participant-notes">
        <ul>
            <li>
                <button class="btn btn-primary btn btn-primary  plr-100 rounded print" type="submit" onClick="window.print()">Print</button>
            </li>
            <li class="timesheet-dropdown">
                <button class="btn btn-primary btn btn-secondary plr-100 ml-30 rounded download" type="submit">Download 
                    <span><i class="fa fa-download" aria-hidden="true"></i></span>
                </button>
            </li>
        </ul>
    </div>
</div>


@section('scripts')

@parent
{{-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> --}}
<script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.62/vfs_fonts.js"></script>
<script>
    jQuery(($)=>{

        $('.datatable').DataTable( {
            dom: 'Bfrtip',
            // paging: false,
            // "searching": false
            buttons: [
                    'print','pdf', 
            ]
        } );

        $('.download').click((e)=>{
            e.preventDefault();
            $('.buttons-pdf').trigger('click');
        })

        // $('.print').click((e)=>{
        //     e.preventDefault();
        //     $('.buttons-print').trigger('click');
        // })

        
        
    })

</script>

@endsection