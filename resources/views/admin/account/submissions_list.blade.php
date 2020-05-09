
<form action="{{ (isset($link['href_link'])) ? route($link['href_link'], $type) : '#' }}" method="POST" enctype="multipart/form-data">

    @csrf

    @method('PUT')

    <div class="card-body mt-2">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>
                            {{ trans('accounts.headings.participant') }}
                        </th>
                        <th>
                            {{ trans('accounts.headings.support_worker') }}
                        </th>
                        <th>
                            {{ trans('accounts.headings.groups') }}
                        </th>                            
                        <th>
                            {{ trans('accounts.headings.item_number') }}
                        </th>
                        <th>
                            {{ trans('accounts.headings.claim_type') }}
                        </th>
                        <th>
                            {{ trans('accounts.headings.start_time') }}
                        </th>
                        <th>
                            {{ trans('accounts.headings.finish_time') }}
                        </th>
                        <th>
                            {{ trans('accounts.headings.total_amount') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @php 
                        $i = 0
                    @endphp --}}


                    
                    @if($records->count())
                        @foreach($records as $key => $timesheet)
                            {{-- {{ $i++ }} --}}
                            <tr data-entry-id="{{ $timesheet->id }}">

                                <td>    
                                {{ $timesheet->participant_name }}
                                </td>

                                <td>    
                                {{ $timesheet->supp_wrkr_ext_name }}
                                </td>

                                <td>
                                    
                                </td>

                                <td>    
                                    {{ $timesheet->item_number }}
                                    ({{ $timesheet->title }})
                                </td>
                                
                                
                                <td>
                                    {{ $timesheet->booking_type}}
                                </td>

                                <td>
                                    {{ dbToDatetime( $timesheet->starts_at ) ?? '' }}
                                </td>

                                <td>
                                    {{ dbToDatetime( $timesheet->ends_at ) ?? '' }}
                                </td>

                                <td>
                                    {{ $timesheet->total_amount}}
                                </td>

                                <td>
                                    <input type="checkbox" name="paid[]" value="{{ $timesheet->id }}">
                                    <input type="hidden" name="participant_id[]" value="{{ $timesheet->participant_id }}">
                                    
                                </td>

                            </tr>
                        @endforeach
                      @else
                        <tr>
                            <td colspan="8" class="text-center">
                                You’re all up to date
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    {{-- @if($i) --}}
    @if($records->count() > 0)
        {!! 
            Form::submit('Paid')->attrs(["class"=>"btn btn-primary rounded"]) 
        !!}
    @endif
    {{-- @endif --}}
</form>

{{-- @section('scripts')
@parent
<script>
    $(function () {
        
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons });
    
    })
</script>
@endsection --}}