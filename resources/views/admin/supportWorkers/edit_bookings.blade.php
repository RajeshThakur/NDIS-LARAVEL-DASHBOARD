    <form action="{{ route("admin.support-workers.bookings", [$supportWorker->user_id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        
        
        <div>

            <input type="hidden" id="provider_id" name="provider_id" class="form-control" value="{{ \Auth::user()->id }}" />
            <input type="hidden" id="support_worker_id" name="support_worker_id" class="form-control" value="{{ old('user_id', isset($supportWorker) ? $supportWorker->user_id : 0) }}" />
            <input type="hidden" id="start_date" name="start_date" class="form-control" value="" />
            <input type="hidden" id="end_date" name="end_date" class="form-control" value="" />
            
            <div class="booking-document form-mt">
                <div class="row">

                    {!! Form::select('member', trans('participants.title_singular'), isset($supportWorker->participants) ? $supportWorker->participants : array('No Selectable Participant is Available'))->size('col-sm-6') !!}
                   
                    {{--
                    {!!
                        Form::date('end_date_ndis',  trans('sw.fields.date'), "23/04/19")->id("end_date_ndis")->attrs(["data-toggle"=>"datetimepicker", "data-target"=>"#end_date_ndis"])->size('col-sm-6') 
                    !!}
                    --}}

{{-- 
                     {!! 
                        Form::date('date_range', 'Date Range', '' )->id('date_range')->size('col-sm-4')->help(trans('participants.fields.start_date_ndis_helper'))
                    !!} --}}
                     <div id="dm-daterange" class="col-sm-4">
                        <div class="form-group">
                                <label for="daterange" class="">Date Range</label>
                                <div class="input-group">
                                    <input type="text"  id="date_range" class="form-control form-control-col-sm-6">
                                    <i class="inputicon fa fa-calendar-o" aria-hidden="true"></i>
                                   
                                </div>
                                <small class="form-text text-muted">&nbsp;</small>
                            </div>
                    </div>
                    

                   


                    <div class="col-sm-2">
                        <div class="service-booking search-btn">
                            <div class="form-group ">
                                <label for="first_name">&nbsp;</label>
                                <button type="search">Search</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="support-booking col-sm-12">
                        <div class="create-new edit-new">
                            <button class="btn btn-primary   plr-100 rounded" type="submit" value="{{ trans('sw.tabs.edit') }}">Edit</button>
                            <button class="btn btn-primary ml-30 rounded" type="submit" value="{{ trans('sw.tabs.create_new_booking') }}">Create New Booking</button>
                        </div>
                    </div>
                </div>

            <div>
            {{-- <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}"> --}}
        </div>
    </form>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>
                            No 
                        </th>
                        <th>
                            Name of Participant
                        </th>
                        <th>
                            Item No
                        </th>
                                                  
                        <th>
                            Start Time
                        </th>
                        <th>
                            End Time
                        </th>
                        <th>
                            Service Type
                        </th>
                        <th>
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if( count($supportWorker->bookings) )
                    @foreach($supportWorker->bookings as $key => $booking)
                        <tr data-entry-id="{{ $booking->booking_id }}">
                            <td>
                                @can('service_booking_edit')
                                <a class="" href="{{ route('admin.bookings.edit', $booking->id) }}">
                                    {{ $key + 1 }}
                                </a>
                                @endcan
                            </td>
                            <td>
                                @can('service_booking_edit')
                                <a class="" href="{{ route('admin.bookings.edit', $booking->id) }}">
                                    {{ \App\User::find($booking->participant_id)->first_name ?? '' }}
                                    {{ \App\User::find($booking->participant_id)->last_name ?? '' }}
                                </a>
                                @endcan
                            </td>                            
                            
                            <td>
                                @can('service_booking_edit')
                                <a class="" href="{{ route('admin.bookings.edit', $booking->id) }}">
                                    {{ $booking->item_number ?? '' }}
                                </a>
                                @endcan
                            </td>

                            <td>
                                @can('service_booking_edit')
                                <a class="" href="{{ route('admin.bookings.edit', $booking->id) }}">
                                    {{ dbToDatetime($booking->starts_at) ?? '' }}
                                </a>
                                @endcan
                            </td>
                            <td>
                                @can('service_booking_edit')
                                <a class="" href="{{ route('admin.bookings.edit', $booking->id) }}">
                                    {{ dbToDatetime($booking->ends_at) ?? '' }}
                                </a>
                                @endcan
                            </td>
                            <td>
                                @can('service_booking_edit')
                                <a class="" href="{{ route('admin.bookings.edit', $booking->id) }}">
                                    {{ $booking->service_type }}
                                </a>
                                @endcan
                            </td>
                            <td>
                                @can('service_booking_edit')
                                <a class="" href="{{ route('admin.bookings.edit', $booking->id) }}">
                                    {{ trans('bookings.statuses.'.$booking->status) }}
                                </a>
                                @endcan
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
    $(function() {
      $('#date_range').daterangepicker({
        // opens: 'left',
        startDate: Date.now(),
        minDate: Date.now(),
        autoApply: true,
        locale: {
            format: 'Do MMM, YYYY',
            separator: '  To  '
        }
      });
      
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons });
       
    });


</script>
@endsection