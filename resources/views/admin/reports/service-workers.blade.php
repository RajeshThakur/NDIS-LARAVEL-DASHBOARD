@extends('layouts.admin')
@section('content')
<div class="card">   
    <div class="card-header">
        <div class="row">
                
            <a href="{{ url('admin/reports')}}"><span><i class="fa fa-arrow-left left-arrow-back" aria-hidden="true"></i></span></a>
            <div class="pageTitle">
            <h2>Reports - Service Workers</h2>
            </div>            
        </div>
    </div>

 
    <div class="serchbaar">
            <form action="{{ route("admin.reports.service-workers") }}" method="GET" class="m-0" role="search">
                @csrf
                <div class="row">                    
                    {!!
                        Form::text('member', 'Service Worker', '')->size('col-sm-10')->id('member')->placeholder('Search service worker by name and email')
                    !!}


    
                    <div class="col-md-2">
                        <div class="input-group">
                            <label for="end_date">&nbsp;</label>
                            <button type="submit" class="btn btn-success rounded">
                                <span class="glyphicon glyphicon-search"><i class="fa fa-search white-icon"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    


    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                       
                        <th>
                                Service Worker 
                        </th>
                        <th>
                            Address 
                        </th>
                       
                        <th>
                            Mobile 
                        </th>
                        <th>
                            Group Id
                        </th>
                       
                    </tr>
                </thead>
                @if($externals->isEmpty())

                <tbody>                   
                    <tr >
                        <td>
                            
                        </td> 
                        
                        <td>
                            No service worker found
                        </td> 
                        <td>
                            
                        </td> 
                        <td>
                            
                        </td> 
                    </tr>                
                </tbody>
                @else
                <tbody>
                    @foreach($externals as $key => $external) 
                        <tr data-entry-id="{{ $external->id }}">
                            <td> 
                                <a class="" href="{{ route('admin.provider.edit', $external->id) }}">
                                    {{ $external->first_name ?? '' }}
                                    {{ $external->last_name ?? '' }}
                                </a>
                            </td>
                            <td>
                                {{ $external->address ?? '' }}
                            </td>
                            <td>
                                {{ $external->mobile ?? '' }}
                            </td>
                            <td>
                                @foreach($external->reg_grps as $key => $reg)
                                    {{ $reg->reg_group_id . ', '}}
                                @endforeach
                            </td>
                           
                            
                           
                        </tr>
                    @endforeach
                </tbody>
                @endif                
            </table>

            @if( ! $externals->isEmpty())
            <div class="account-sub-button">
                    <div class="create-new edit-new participant-notes">
                        <ul>
                            <li><button class="btn btn-primary btn btn-primary  plr-100 rounded" type="submit" onClick="window.print()">Print</button></li>
                            <li class="timesheet-dropdown">
                                <button class="btn btn-primary btn btn-secondary plr-100 ml-30 rounded download" type="submit">Download 
                                    <span><i class="fa fa-download" aria-hidden="true"></i></span>
                                </button>
                                {{-- <ul class="show-list">
                                    <li><a href="#">Demo 1</a></li>
                                    <li><a href="#">Demo 2 </a></li>
                                </ul> --}}
                            </li>
                        </ul>
                    </div>
                </div>
            @endif    
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
   $(function () {
        
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons });
    })

</script>
@endsection