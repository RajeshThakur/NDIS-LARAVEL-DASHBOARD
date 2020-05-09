@extends('layouts.admin')
@section('content')
 {{-- @can('support_worker_create')
    <div style="margin-bottom: 10px;" class="row mt-button">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.support-workers.create") }}">
                {{ trans('global.add') }} {{ trans('sw.title_singular') }}
            </a>
        </div>
    </div>
@endcan  --}}
<div class="card">
 {{-- <div class="card-header">
        {{ trans('sw.title_singular') }} {{ trans('global.list') }}
    </div>  --}}
     <div class="card-header mb-4">
        <div class="row">
            <div class="pageTitle">
                <h2>{{ trans('global.Support_Worker.Support_Worker_List') }}</h2>
            </div>
            @php if( !checkUserRole('1') ): @endphp
            <div class="icons ml-auto order-last" id="intro_step1"  data-intro="Add to create Support Worker list">
                <a class="btn btn-success hint_top rounded" aria-label="Add Support Worker" href="{{ route("admin.support-workers.create") }}">{{ trans('global.Support_Worker.Support_Worker_button') }}</a>
            </div>
            @php endif; @endphp
        </div> 
    </div>

    {{-- <div class="Search-Results">
        <h2>Search Results</h2>
    </div> --}}

    <div class="serchbaar mt-3" data-step="3"  data-intro="Filter Support Worker by First/Last name or Email">
        <form action="{{ route("admin.support-workers.index") }}" method="GET" class="m-0" role="search">
            <div class="input-group">
                {!! 
                    Form::text('s','',old('first_name', isset($query) ? $query : ''))
                    ->placeholder('First Name, Last Name or Email')
                    ->attrs(['class'=>'badge-pill bg-white']) 
                !!}
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"><img class="search" src="{{url('img/search.png')}}" alt="NDIS" /></span>
                    </button>
                </span>
            </div>
        </form>
    </div> 
    <div class="">       
        @if( isset($supportWorkers->search))        
            {!! $supportWorkers->search['message'] !!}
        @endif
    </div> 

    <div class="card-body" data-step="2" data-intro="List of All your existing Support Worker">
        <div class="table-responsive cursor-custom">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        
                        <th>
                            {{ trans('sw.fields.first_name') }}
                        </th>
                        <th>
                            {{ trans('sw.fields.last_name') }}
                        </th>
                        <th>
                            {{ trans('sw.fields.email') }}
                        </th>
                        <th>
                            {{ trans('sw.fields.mobile') }}
                        </th>
                        <th class="">
                            {{ trans('sw.fields.completed') }}
                        </th>
                        <th>
                            {{ trans('global.active') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if($supportWorkers->count())
                        @foreach($supportWorkers as $key => $supportWorker)
                        
                            <tr data-href="{{ route('admin.support-workers.edit', $supportWorker->user_id) }}" data-entry-id="{{ $supportWorker->user_id }}">
                                
                                <td>
                                    <a class="icon" href="{{ route('admin.support-workers.edit', $supportWorker->user_id) }}">{{ $supportWorker->first_name ?? '' }}</a>
                                </td>
                                <td>
                                    <a class="icon" href="{{ route('admin.support-workers.edit', $supportWorker->user_id) }}">{{ $supportWorker->last_name ?? '' }}</a>
                                </td>
                                <td>
                                    <a class="icon" href="{{ route('admin.support-workers.edit', $supportWorker->user_id) }}">{{ $supportWorker->email ?? '' }}</a>
                                </td>
                                <td>
                                    <a class="icon" href="{{ route('admin.support-workers.edit', $supportWorker->user_id) }}">{{ $supportWorker->mobile ?? 'N/A' }}</a>
                                </td>
                                <td class="">
                                    <a class="icon" href="{{ route('admin.support-workers.edit', $supportWorker->user_id) }}">{{ $supportWorker->is_onboarding_complete ? 'Yes': 'No' }}</a>
                                </td>
                                <td class="text-right">
                                    @if($supportWorker->active )
                                        <span class="activate-yes">Yes</span>
                                    @else 
                                        <a class="resend_email" data-id="{{ $supportWorker->user_id }}">{{ trans('global.resend_activation_mail')  }}</a> 
                                    @endif                                   
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center">
                                No Records Found!
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {

        localStorage.removeItem("is_popup_closed");

        var introGiven = localStorage.getItem("supportworker_intro_given");
        if(!introGiven){
            introJs().start();
            localStorage.setItem("supportworker_intro_given", true);
        }

        $('*[data-href]').on("click",function(){
            window.location = $(this).data('href');
            return false;
        });
        $("td > a").on("click",function(e){
            e.stopPropagation();
        });

        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons });

    })

    $('.resend_email').click(function(e){
        console.log($(this));
        // return false;
        ndis.ajax(
            '{{ route("admin.resend.activation.email") }}',
            'POST',
            {
                'user_id': $(this).data('id')
            },
            function(data) {
                console.log(data);                
                alert(data.message)
            },
            function(jqXHR, textStatus) {
                // form.find(".modal__content").prepend( ndis.error( jqXHR.responseJSON.message ) )
            }
        );
        return false;
    })




</script>
@endsection