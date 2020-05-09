    <form action="{{ route("admin.participants.bookings", [$participant->user_id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div>

            <input type="hidden" id="user_id" name="user_id" class="form-control" value="{{ old('user_id', isset($participant) ? $participant->user_id : 0) }}" />
            <input type="hidden" id="provider_id" name="provider_id" class="form-control" value="{{ old('provider_id', isset($participant) ? $participant->user->provider_id : 0) }}" />

            <div class="booking-document form-mt">
                <div class="row">

                    {!! Form::text('first_name', trans('sw.title_singular'))->id('first_name')->size('col-sm-6') !!}

                    {!! Form::datetime('end_date_ndis', trans('bookings.fields.date'))->id('end_date_ndis')->size('col-sm-4') !!}

                    <div class="col-sm-2">
                        <div class="service-booking search-btn">
                            <div class="form-group ">
                                <label for="first_name">&nbsp;</label>
                                <button type="search">Search</button>
                            </div>
                        </div>
                    </div>

                    <div class="create-new edit-new col-sm-12">
                        {!! 
                            Form::submit(trans('participants.tabs.edit'))->attrs(["class"=>"btn btn-primary rounded plr-100"]) 
                        !!}

                        {!! 
                            Form::submit(trans('participants.tabs.create_new_booking'))->attrs(["class"=>"btn btn-success rounded ml-30"]) 
                        !!}
                    </div>
                </div>

            <div>
            {{-- <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}"> --}}
        </div>
    </form>