@extends('layouts.admin')
@section('content')

<div class="card">

    <div class="card-header mb-4">
        <div class="row">
            <div class="pageTitle">
             <h2> {{ trans('serviceProvider.title_singular') }} {{ trans('global.list') }}</h2>
            </div>
            @php if( !checkUserRole('1') ): @endphp
            <div class="icons ml-auto order-last" id="intro_step1"  data-intro="Add to create External Service Provider">
                @can('external_service_provider_create')
                <a class="btn btn-success rounded" href="{{ route("admin.provider.create") }}">
                    {{ trans('global.add') }} {{ trans('serviceProvider.title_singular') }}
                </a>
                @endcan
            </div>
            @php endif; @endphp
        </div>
    </div>

    {{-- <div class="Search-Results">
        <h2>Search Results</h2>
    </div> --}}

   <div class="serchbaar mt-3" data-step="3"  data-intro="Filter External Service Provider by First/Last name or Email">
        <form action="{{ route("admin.provider.index") }}" method="GET" class="m-0" role="search">

            <div class="input-group">
                {!! 
                    Form::text('q',  '', '' )->placeholder('Search External Service List')->attrs(["class"=>"badge-pill bg-white"])
                !!}
                 <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"><img class="search" src="{{url('img/search.png')}}" alt="NDIS" /></span>
                    </button>
                </span>
            </div>

        </form>
    </div>

    <div class="card-body" data-step="2" data-intro="List of All your existing External Service Provider">
        <div class="table-responsive cursor-custom">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('serviceProvider.fields.first_name') }}
                        </th>
                        <th>
                            {{ trans('serviceProvider.fields.last_name') }}
                        </th>
                        <th>
                            {{ trans('serviceProvider.fields.email') }}
                        </th>
                        <th>
                            {{ trans('serviceProvider.fields.mobile') }}
                        </th>
                        <th>
                            {{ trans('serviceProvider.fields.agreement_signed') }}
                        </th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($serviceProviders as $key => $serviceProvider)
                        <tr data-href="{{ route('admin.provider.edit', $serviceProvider->user_id) }}" data-entry-id="{{ $serviceProvider->id }}">
                            <td>
                            </td>
                            <td>
                               <a class="" href="{{ route('admin.provider.edit', $serviceProvider->user_id) }}">
                                 {{ $serviceProvider->user->first_name ?? '' }}</a>
                            </td>
                            <td>
                               <a class="" href="{{ route('admin.provider.edit', $serviceProvider->user_id) }}">
                                 {{ $serviceProvider->user->last_name ?? '' }}</a>
                            </td>
                            <td>
                                <a class="" href="{{ route('admin.provider.edit', $serviceProvider->user_id) }}">
                                    {{ $serviceProvider->user->email ?? '' }}
                                </a>
                            </td>
                            <td>
                                {{ $serviceProvider->user->mobile ?? '' }}
                            </td>
                            <td class="text-right">
                                {{ $serviceProvider->agreement_signed ? 'Yes':'No' }}
                            </td>

                        </tr>
                    @endforeach
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

        var introGiven = localStorage.getItem("externalservice_intro_given");
        if(!introGiven){
            introJs().start();
            localStorage.setItem("externalservice_intro_given", true);
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



</script>
@endsection