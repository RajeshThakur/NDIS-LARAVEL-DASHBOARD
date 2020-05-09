
<div>

        <div class="participant-document form-mt">


                {{-- <div class="jumbotron" id="onboard-message">            
                    <div class="col-lg-12">
                        <h3 classs="alert-heading">{{$supportWorker->payment_history}}</h3>
                        <hr class="my-4">                                
                    </div> 
                </div> --}}
    
    
            <div class="table-responsive">                    
                <table class=" table table-bordered table-striped table-hover datatable">
                    <thead>
                        <tr>
                            <th width="10"></th> 
                            <th scope="col">{{ trans('sw.tabs.date') }}</th>
                            <th scope="col">{{ trans('sw.tabs.amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                         @if( count( $supportWorker->bookingOrder) )
                    @foreach( $supportWorker->bookingOrder as $key => $order )
                        {{-- @if( ( ! empty($order->timesheet->payouts)) ) --}}
                        @if( $order->status == "Paid" )
                            <tr data-entry-id="{{$order->id}}">
                                <td>
                                   
                                </td>
                            
                                <td>
                                        {{ dbToDatetime($order->timesheet->payouts->created_at) }}
                                </td>
                                <td>
                                        {{ $order->timesheet->payable_amount }}
                                </td>                            
                            </tr>
                        @endif
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
        