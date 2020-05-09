@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-header mb-4">
         <div class="row">
               <div class="pageTitle">
                  <h2>{{ trans('opforms.title') ." ". trans('global.list') }}</h2>
               </div>
               <div class="icons ml-auto order-last">
                  <a class="btn btn-success hint--top rounded" id="addForm" aria-label="{{ trans('global.add') ." " . trans('opforms.title_singular')  }}" href="#">{{ trans('global.add') ." " . trans('opforms.title_singular')  }}</a>
               </div>
         </div>
      </div>
    
      <div class="serchbaar mt-3">
         <form action="{{ route("admin.forms.index") }}" method="GET" class="m-0" role="search">
               <div class="input-group">
                  {!! 
                     Form::text('q','', old('first_name', isset($query) ? $query : ''))
                     ->placeholder('Search form by title..')
                     ->attrs(["class"=>"external-service  badge-pill bg-white"])
                  !!}
                  <span class="input-group-btn">
                     <button type="submit" class="btn btn-default">
                           {{-- <span class="glyphicon glyphicon-search"><i class="fa fa-search"></i></span> --}}
                           <img class="search" src="http://localhost:8000/img/search.png" alt="NDIS">
                     </button>
                  </span>
               </div>
         </form>
      </div>
   
      <div class="card-body">

         <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable">
               <thead>
                  <tr>
                     <th>
                           {{ trans('opforms.fields.title') }}
                     </th>
                     <th>
                           {{ trans('opforms.fields.user_name') }}
                     </th>
                     <th>
                           {{ trans('opforms.fields.type') }}
                     </th>
                     <th>
                           {{ trans('opforms.fields.date') }}
                     </th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($opforms as $key => $form)
                     <tr data-entry-id="{{ $form->id }}">
                        <td>
                              <a href="{{ route('admin.forms.edit', $form->id) }}">{{ $form->optitle ?? '' }}</a>
                        </td>
                        <td>
                              <a href="{{ route('admin.forms.edit', $form->id) }}">{{ getName($form->first_name, $form->last_name) ?? '' }}</a>
                        </td>
                        <td>
                              <a href="{{ route('admin.forms.edit', $form->id) }}">{{ $form->role ?? '' }}</a>
                        </td>
                        <td>
                              <a href="{{ route('admin.forms.edit', $form->id) }}">{{ $form->date ?? '' }}</a>
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
</div>
@endsection


@section('bottom')
   @parent
   <div id="popupForms">
        @include( 'admin.operationalForms.popups.add' )
   </div>
@endsection

@section('scripts')
@parent
<script>
   $(function () {

      jQuery("#addForm").on('click', function(ev){
         ev.preventDefault();

         ndis.popup( 'add_form' );

      })

      let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
      $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons })
      
   })

</script>
@endsection