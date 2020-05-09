@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-body">
      <div class="operational-form-design">
         {{-- 5th client-progress form start here--}}
         <form action="{{ route($formAction[0],$formAction[1]) }}" method="POST" class="validated" enctype="multipart/form-data">
            @csrf
            @if(!empty($formAction[1]))
            @method('PUT')        
            @endif
            <div class="card-header">
               <h2>Client Progress Form</h2>
            </div>
            <input type="hidden" name="template_id" value="5">
            <input type="hidden" name="user_id" value='{{$participant->user_id}}'>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.client_surname')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('client_surname', '', old('full_name', $participant->last_name ))
                  ->id('client_surname') 
                  ->readonly($readOnly)
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{ trans('opforms.fields.given_name')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[given_name]', '', old('full_name', $participant->first_name ))
                  ->id('given_name') 
                  ->readonly($readOnly)
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{ trans('opforms.fields.date_of_birth')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::date('meta[date_of_birth]', '', old('date_of_birth', isset($meta['date_of_birth']) ? $meta['date_of_birth'] : date('d-m-Y')))
                  ->id('date-1')
                  ->required('required')
                  ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Date of birth reqired" ])
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="form-group">
               <h3>CLIENT PROGRESS NOTES</h3>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.date_time')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::datetime('meta[progress_date_time]',  '', old('progress_date_time', isset($meta['progress_date_time']) ? $meta['progress_date_time'] : date('d-m-Y H:i:s')))
                  ->id('datetime-1')
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.notes_text')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::textarea('meta[notes_text]', '', issetKey( $meta, 'notes_text', '' ))
                  !!}
               </div>
            </div>
            <div class="form-group {{ $errors->has('signed') ? 'has-error' : '' }}">
               <label style="text-align:right;" for="signed">Client Progress Notes</label>
            </div>
            {!! Form::submit('Submit')->attrs(["class"=>"rounded"]) !!}
         </form>
         {{-- 5th client-progress form end here--}}
      </div>
   </div>
</div>
@endsection