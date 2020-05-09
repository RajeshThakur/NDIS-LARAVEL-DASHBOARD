    <form action="{{ route("admin.participants.update", [$participant->id]) }}" class="validated" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row form-mt">

            {!! 
                Form::text('first_name', trans('participants.fields.first_name'), old('first_name', isset($participant) ? $participant->first_name : '') )
                ->id('first_name')
                ->attrs([ 
                    "required"=>"required", 
                    "data-rule-required"=>"true", 
                    "data-msg-required"=>trans('errors.participants.first_name') 
                ])
                ->size('col-sm-6')
                ->help(trans('participants.fields.first_name_helper'))
            !!}

            {!! 
                Form::text('last_name', trans('participants.fields.last_name'), old('last_name', isset($participant) ? $participant->last_name : '') )
                ->id('last_name')
                ->attrs([ 
                    "required"=>"required", 
                    "data-rule-required"=>"true", 
                    "data-msg-required"=>trans('errors.participants.last_name') 
                ])
                ->size('col-sm-6')
                ->help(trans('participants.fields.last_name_helper'))
            !!}

            {!! 
                Form::text('email', trans('participants.fields.email'), old('email', isset($participant) ? $participant->email : '') )
                ->id('email')
                ->attrs([ 
                    "required"=>"required", 
                    "data-rule-required"=>"true", 
                    "data-msg-required"=>"Participant email required", 
                    "data-rule-email"=>"true",
                    "data-msg-email"=>trans('errors.participants.email_format')
                ])
                ->size('col-sm-6')
                ->help(trans('participants.fields.email_helper'))
            !!}

            {!! 
                Form::location('address', trans('participants.fields.address'), old('address', isset($participant) ? $participant->address : ''), old('lat', isset($participant) ? $participant->lat : ''), old('lng', isset($participant) ? $participant->lng : '') )
                        ->id('address')
                        ->attrs([ 
                            "required"=>"required", 
                            "data-rule-required"=>"true", 
                            "data-msg-required"=>trans('errors.participants.address') 
                        ])
                        ->size('col-sm-6')
                        ->help(trans('participants.fields.address_helper'))
            !!}

            {!! 
                Form::text('ndis_number', trans('participants.fields.ndis_number'), old('ndis_number', isset($participant) ? $participant->ndis_number : '') )
                ->id('ndis_number')
                ->attrs([ 
                    "required"=>"required", 
                    "data-rule-required"=>"true", 
                    "data-msg-required"=>trans('errors.participants.ndis_number')  
                ])
                ->size('col-sm-6')
                ->help(trans('participants.fields.ndis_number_helper'))
            !!}

            <div class="col-sm-6">
                <div class="row ml-mr-none">
                    {!! 
                        Form::date('start_date_ndis', trans('participants.fields.start_date_ndis'), old('start_date_ndis', isset($participant) ? $participant->start_date_ndis : '') )
                        ->id('start_date_ndis')
                        ->attrs([ 
                            "required"=>"required", 
                            "data-rule-required"=>"true", 
                            "data-msg-required"=>trans('errors.participants.start_date_ndis'),
                            "data-rule-dateFormat"=>"true",
                            "data-msg-dateFormat"=>trans('errors.participants.start_date_ndis_format')
                        ])
                        ->size('col-sm-6')
                        ->help(trans('participants.fields.start_date_ndis_helper'))
                    !!}

                    {!! 
                        Form::date('end_date_ndis', trans('participants.fields.end_date_ndis'), old('end_date_ndis', isset($participant) ? $participant->end_date_ndis : '') )
                        ->id('end_date_ndis')
                        ->attrs([ 
                            "required"=>"required", 
                            "data-rule-required"=>"true", 
                            "data-msg-required"=>trans('errors.participants.end_date_ndis'),
                            "data-rule-dateFormat"=>"true",
                            "data-msg-dateFormat"=>trans('errors.participants.end_date_ndis_format')
                        ])
                        ->size('col-sm-6')
                        ->help(trans('participants.fields.end_date_ndis_helper'))
                    !!}
                </div>
            </div>

            {!! 
                Form::text('funding_remaining', trans('participants.fields.funding_remaining'), old('funding_remaining', isset($participant) ? $participant->funds_balance : '') )
                ->id('funding_remaining')
                ->size('col-sm-6')
                ->attrs(['readonly'=>'readonly'])
                ->help(trans('participants.fields.funding_remaining_helper'))
            !!}

            {!! 
                Form::text('participant_goals', trans('participants.fields.participant_goals'), old('participant_goals', isset($participant) ? $participant->participant_goals : '') )
                ->id('participant_goals')
                ->size('col-sm-6')
                ->help(trans('participants.fields.participant_goals_helper'))
            !!}
            
            {!! 
                Form::textarea('special_requirements', trans('participants.fields.special_requirements'), old('special_requirements', isset($participant) ? $participant->special_requirements : '') )
                ->id('special_requirements')
                ->size('col-sm-12')
                ->help(trans('participants.fields.special_requirements_helper'))
            !!}

        </div>

        
        <div>
            <input type="hidden" id="user_id" name="user_id" class="form-control" value="{{ old('user_id', isset($participant) ? $participant->user_id : 0) }}" />
            <input type="hidden" id="provider_id" name="provider_id" class="form-control" value="{{ old('provider_id', isset($participant) ? $participant->provider_id : 0) }}" />
        </div>

        <div>

            <div class="participant-editer-btn">
                <div class="edit-btn">
                    {!! Form::submit('Save Changes', 'success' )->attrs(["class"=>"btn btn-success btn-secondary rounded plr-100 edit-icon"]) !!}
                </div>
    
                <div class="delete-button">
                    {!! Form::button( trans('global.delete_btn'), 'danger')->attrs(["onclick"=>"return deleteRec();", 'class'=>'rounded']) !!}
                </div>
            </div>
            
        </div>
        
    </form>
    

    @can('participant_delete')
        @include('template.deleteItem', [ 'destroyUrl' => route('admin.participants.destroy', $participant->id) ])
    @endcan


@section('scripts')
    @parent
    <script>
        function deleteRec(){
            if(confirm('{{ trans('global.areYouSure') }}') ){
                document.getElementById('deleteRec').submit();
            }
            return false;
        }
    </script>
@endsection