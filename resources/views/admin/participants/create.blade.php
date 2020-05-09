@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-header participant">
      <span><i class="fa fa-arrow-left" aria-hidden="true"></i></span>
      {{ trans('global.create') }} {{ trans('participants.title_singular') }}
   </div>
   <div class="card-body">
        <form action="{{ route("admin.participants.store") }}" method="POST" class="validated" enctype="multipart/form-data">
            @csrf

            <div class="row">

                {!! 
                    Form::text('first_name', trans('participants.fields.first_name'), old('first_name', isset($participant) ? $participant->first_name : ''))
                    ->id('first_name')
                    ->attrs([ 
                        "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.participants.first_name') 
                    ])
                    ->size('col-sm-6 ')
                    ->help(trans('participants.fields.first_name_helper')) 
                !!}

                {!! 
                    Form::text('last_name', trans('participants.fields.last_name'), old('last_name', isset($participant) ? $participant->last_name : ''))
                    ->id('last_name')
                    ->attrs([ 
                        "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.participants.last_name') 
                    ])
                    ->size('col-sm-6 ')
                    ->help(trans('participants.fields.last_name_helper')) 
                !!}

                {!! 
                    Form::text('email', trans('participants.fields.email'), old('email', isset($participant) ? $participant->email : ''))
                    ->id('email')
                    ->attrs([ 
                        "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>"Participant email required", 
                        "data-rule-email"=>"true",
                        "data-msg-email"=>trans('errors.participants.email_format')
                    ])
                    ->size('col-sm-6 ')
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
                    Form::text('ndis_number', trans('participants.fields.ndis_number'), old('ndis_number', isset($participant) ? $participant->ndis_number : ''))
                    ->id('ndis_number')
                    ->attrs([ 
                        "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.participants.ndis_number')  
                    ])
                    ->size('col-sm-6 ')
                    ->help(trans('participants.fields.ndis_number_helper')) 
                !!}

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
                    ->size('col-sm-3')
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
                    ->size('col-sm-3 ')
                    ->help(trans('participants.fields.end_date_ndis_helper'))
                !!}

                {!! 
                    Form::text('participant_goals', trans('participants.fields.participant_goals'), old('participant_goals', isset($participant) ? $participant->participant_goals : ''))->id('participant_goals')->size('col-sm-12')->help(trans('participants.fields.participant_goals_helper')) 
                !!}

                {!! 
                    Form::textarea('special_requirements', trans('participants.fields.special_requirements'), old('special_requirements', isset($participant) ? $participant->special_requirements : ''))->id('special_requirements')->size('col-sm-12')->help(trans('participants.fields.special_requirements_helper')) 
                !!}
            </div>           
            
            <div>
                {!! Form::submit(trans('global.save'))->attrs(["class"=>"btn btn-primary rounded mt-button"]) !!}
            </div>
        </form>
   </div>
</div>

@endsection
@section('scripts')
@parent
<script>
   jQuery(document).ready(function(){ 
      
   });
</script>

@endsection