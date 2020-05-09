@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-body">
      <div class="operational-form-design">
         {{-- 7th client-spport-review form start here--}}
         <form action="{{ route($formAction[0],$formAction[1]) }}" method="POST" class="validated" enctype="multipart/form-data">
            @csrf
            @if(!empty($formAction[1]))
            @method('PUT')        
            @endif
            <div class="card-header">
               <h2>Support Review Form</h2>
            </div>
            <input type="hidden" name="template_id" value="7">
            <input type="hidden" name="user_id" value='{{$participant->user_id}}'>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.review_form_text_list')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::textarea('meta[review_form_text_list]', '', old('review_form_text_list', isset($opMetaData['review_form_text_list']) ? ($opMetaData['review_form_text_list']) : ''))
                  !!}
               </div>
            </div>
            <div class="form-group {{ $errors->has('Organisation') ? 'has-error' : '' }}">
               <label for="Organisation">Have there been any changes to the following in the last review period? If so, please list.</label>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.goals')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[goals]', '', issetKey( $meta, 'goals', '' ))
                  ->id('goals')
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.strengths')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[strengths]', '', issetKey( $meta, 'strengths', '' ))
                  ->id('strengths')
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.needs')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[needs]', '', issetKey( $meta, 'needs', '' ))
                  ->id('needs')
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.wishes')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[wishes]', '', issetKey( $meta, 'wishes', '' ))
                  ->id('wishes')
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{trans('opforms.fields.review_connex_service')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[review_connex_service]', '', issetKey( $meta, 'review_connex_service', '' ))
                  ->id('review_connex_service')
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{ trans('opforms.fields.review_actions_taken')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[review_actions_taken]','', issetKey( $meta, 'review_actions_taken', '' ))
                  ->id('review_actions_taken')
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{ trans('opforms.fields.delivery_reviewed')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[delivery_reviewed]', '', issetKey( $meta, 'delivery_reviewed', '' ))
                  ->id('delivery_reviewed')
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{ trans('opforms.fields.next_review_date')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::date('meta[next_review_date]', '', old('next_review_date', isset($meta['next_review_date']) ? $meta['next_review_date'] : date('d-m-Y')))
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="below-form pdd-none">
               <div class="form-group {{ $errors->has('Review') ? 'has-error' : '' }}">
                  <h4>AGREEMENT</h4>
               </div>
               <div class="form-group {{ $errors->has('Review') ? 'has-error' : '' }}">
                  <ul>
                     <label>
                        <li>All parties agree with this Review Assessment.</li>
                     </label>
                  </ul>
               </div>
               <div class="form-group {{ $errors->has('Review') ? 'has-error' : '' }}">
                  <ul>
                     <label>
                        <li>A copy of this Review Assessment has been provided to the client (or guardian, if applicable).</li>
                     </label>
                  </ul>
               </div>
            </div>
            <div class="form-group {{ $errors->has('Guardian') ? 'has-error' : '' }}">
               <h4>Client/Guardian</h4>
            </div>
            <h4>Client/Guardian</h4>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{ trans('opforms.fields.full_name')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[guardian]', '', issetKey( $meta, 'guardian', '' ))
                  ->id('guardian')
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  Signature of parent</label>
               </div>
               <div class="col-sm-8">
                  @if(isset($meta['signature_parent']))
                  <img alt="signature_parent" src="{{ $meta['signature_parent'] }}" />
                  @else
                  @include('template.sign_pad', [ 'id' => 'signature_parent', 'user_id'=>0, 'name'=>'meta[signature_parent]', 'label' => 'Parent Signature' ]) 
                  @endif
               </div>
            </div>
            <div class="form-group {{ $errors->has('Guardians') ? 'has-error' : '' }}">
               <h4>Assessing Staff Member</h4>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{  trans('opforms.fields.full_name')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::text('meta[staff_guardians]','', issetKey( $meta, 'staff_guardians', '' ))
                  ->id('staff_guardians')
                  ->help(trans('global.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  {{ trans('opforms.fields.date')}}</label>
               </div>
               <div class="col-sm-8">
                  {!! 
                  Form::date('meta[dated]', '', old('dated', isset($meta['dated']) ? $meta['dated'] : date('d-m-Y')))
                  ->id('date-1')
                  ->required('required')
                  ->attrs([ "required"=>"required", "data-rule-required"=>"true", "data-msg-required"=>"Staff signature date required" ])
                  ->help(trans('lobal.user.fields.name_helper'))
                  !!}
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <label>  Signature of staff</label>
               </div>
               <div class="col-sm-8">
                  @if(isset($meta['signature_of_staff']))
                  <img alt="signature_of_staff" src="{{ $meta['signature_of_staff'] }}" />
                  @else
                  @include('template.sign_pad', [ 'id' => 'signature_of_staff', 'user_id'=>0, 'name'=>'meta[signature_of_staff]', 'label' => 'Signature Of Staff' ]) 
                  @endif
               </div>
            </div>
            {!! Form::submit('Submit')->attrs(["class"=>"rounded mt-40"]) !!}
         </form>
         {{-- 7th client-spport-review form end here--}}
      </div>
   </div>
</div>
@endsection