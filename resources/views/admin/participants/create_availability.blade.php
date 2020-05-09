<form action="{{ route("admin.participants.availability", [$participant->user_id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div>

            <input type="hidden" id="user_id" name="user_id" class="form-control" value="{{ old('user_id', isset($participant) ? $participant->user_id : 0) }}" />
            <input type="hidden" id="provider_id" name="provider_id" class="form-control" value="{{ old('provider_id', isset($participant) ? $participant->user->provider_id : 0) }}" />
            {{-- <div  class="tab participant-three" data-id="tab3"> --}}
            <div class="table-responsive participant-availability form-mt">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">{{ trans('participants.tabs.days') }}</th>
                            <th scope="col">{{ trans('participants.tabs.time_period') }}</th>
                            <th scope="col">{{ trans('participants.tabs.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @if( count($availabilities) )
                            @foreach($availabilities as $key => $availability)

                                <tr class="availability_row" id="availability_{{$availability->id}}" data-id="{{$availability->id}}" >
                                    <td>
                                        <div class=" mb-3 text-left rangeplaceholder">
                                            {{ ucfirst($availability->range) }}
                                        </div>
                                        {!!
                                            Form::select('range', 'Range', $availabiltyRange, isset($availability->range) ? $availability->range : '')
                                                ->id('range_'.$availability->id)
                                                ->required('required')
                                                ->hideLabel()
                                                ->attrs(['class'=>'range'])
                                                ->size('col-sm-12');
                                        !!}
                                    </td>
                                    <td >
                                        <div class=" mb-3 text-center inputplaceholder">
                                            From {{(isset($availability->from) ? $availability->from : 'N/A')}} - {{isset($availability->to) ? $availability->to : 'N/A'}}
                                        </div>
                                        <div class=" input-group mb-3 bg-select">
                                            {!!
                                                Form::time('availability['.$availability->range.'][from]', '', isset($availability->from) ? $availability->from : '')
                                                    ->id('availability_'.$availability->range.'_from')
                                                    ->placeholder('From')
                                                    ->required('required')
                                                    ->hideLabel()
                                                    ->attrs(['class'=>'from'])
                                                    ->size('col-sm-6');
                                            !!}
                                            {!!
                                                Form::time('availability['.$availability->range.'][to]', '', isset($availability->to) ? $availability->to : '')
                                                    ->id('availability_'.$availability->range.'_to')
                                                    ->placeholder('To')
                                                    ->required('required')
                                                    ->hideLabel()
                                                    ->attrs(['class'=>'to'])
                                                    ->size('col-sm-6');
                                            !!}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="edit-remove">
                                            <a class="save" href="javascript://"><span><i class="fa fa-check" aria-hidden="true"></i></span></a>
                                            <a class="edit" href="javascript://"><span><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>
                                            <a class="remove" href="javascript://"><span><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="6" class="text-center">
                                No Records Found!
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>

                <div class="creat-new-avaibility">
                    <input class="btn btn-primary plr-100 rounded" type="submit" value="{{ trans('participants.tabs.create_new_availability') }}">
                </div>
            </div>

        </div>
    </form>