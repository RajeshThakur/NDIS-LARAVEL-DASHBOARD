    <form action="{{ route("admin.participants.bookings", [$participant->user_id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        
        
        <div>
            <input type="hidden" id="user_id" name="user_id" class="form-control" value="{{ old('user_id', isset($participant) ? $participant->user_id : 0) }}" />

            <input type="hidden" id="participant_id" name="participant_id" class="form-control" value="{{ old('user_id', isset($participant) ? $participant->user_id : 0) }}" />
            <input type="hidden" id="provider_id" name="provider_id" class="form-control" value="{{ old('provider_id', isset($participant) ? $participant->user->provider_id : 0) }}" />
            <input type="hidden" id="start_date" name="start_date" class="form-control" value="" />
            <input type="hidden" id="end_date" name="end_date" class="form-control" value="" />


            <div class="booking-document form-mt">
                <div class="row">

                   
                    {!! Form::select('member', trans('sw.title_singular'), isset($participant->sw) ? $participant->sw : array('No Selectable Support Worker is Available'))->size('col-sm-6') !!}

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

                    <div class="create-new edit-new col-sm-12 mb-2">
                        {!! 
                            Form::submit(trans('participants.tabs.edit'))->attrs(["class"=>"btn btn-primary rounded plr-100"])
                        !!}

                        {!! 
                            Form::submit(trans('participants.tabs.create_new_booking'))->attrs(["class"=>"btn btn-primary rounded ml-30"])->id('redirect_booking')
                        !!}
                    </div>
                </div>

            <div>
            {{-- <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}"> --}}
        </div>
    </form>

    <div class="card-body mt-2">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>
                            No 
                        </th>
                        <th>
                            Support Worker 
                        </th>
                        <th>
                            Location
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
                    @if( count($participant->bookings) )
                    @foreach($participant->bookings as $key => $booking)

                        @php $bookingRoute = route('admin.bookings.edit', $booking->id) @endphp
                        @if(in_array($booking->status, [config('ndis.booking.statuses.NotSatisfied'),config('ndis.booking.statuses.Pending'),config('ndis.booking.statuses.Cancelled'),config('ndis.booking.statuses.Approved')]))
                         @php $bookingRoute = route('admin.bookings.detail', $booking->id)  @endphp
                        @endif
                        
                        <tr data-entry-id="{{ $booking->id }}">
                            <td >
                                @can('service_booking_edit')
                                    <a class="" href="{{ $bookingRoute }}">
                                    {{ $key + 1 }}
                                    </a>
                                @endcan
                            </td>
                            <td>
                                @can('service_booking_edit')
                                    <a class="" href="{{ $bookingRoute }}">
                                        {{ $booking->supportWorker->first_name ?? '' }}
                                        {{ $booking->supportWorker->last_name ?? '' }}

                                    </a>
                                @endcan
                            </td>
                            
                            
                            <td>
                                @can('service_booking_edit')
                                    <a class="" href="{{ $bookingRoute }}">
                                    {{ $booking->location ?? '' }}
                                    </a>
                                @endcan
                            </td>
                            <td>
                                @can('service_booking_edit')
                                    <a class="" href="{{ $bookingRoute }}">
                                    {{ dbToDatetime($booking->starts_at) ?? '' }}
                                    </a>
                                @endcan
                            </td>
                            <td>
                                @can('service_booking_edit')
                                    <a class="" href="{{ $bookingRoute }}">
                                    {{ dbToDatetime($booking->ends_at) ?? '' }}
                                    </a>
                                @endcan
                            </td>
                            <td>
                                @can('service_booking_edit')
                                    <a class="" href="{{ $bookingRoute }}">
                                    {{ $booking->service_type }}
                                    </a>
                                @endcan
                            </td>
                            <td>
                                @can('service_booking_edit')
                                    <a class="" href="{{ $bookingRoute }}">
                                    {{ trans('bookings.statuses.'.$booking->status) }}
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                      @else
                        <tr class="empty">
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

      $('#redirect_booking').on('click',function(e){
            e.preventDefault();
            if({{$participant->is_onboarding_complete}})
                window.location.href = "{{route('admin.bookings.create',$participant->user_id)}}";
            else
                // alert('Please complete participant on-boarding')
                ndis.popup( 'step'+{{$participant->onboarding_step}} );
            
      });

      let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons });

    });

</script>
@endsection