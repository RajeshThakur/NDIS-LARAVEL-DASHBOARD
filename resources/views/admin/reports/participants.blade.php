@extends('layouts.admin')
@section('content')
<div class="card">   
    <div class="card-header">
        <div class="row">
                
            <a href="{{ url('admin/reports')}}"><span><i class="fa fa-arrow-left left-arrow-back" aria-hidden="true"></i></span></a>
            <div class="pageTitle">
            <h2>Reports - Participants</h2>
            </div>            
        </div>
    </div>

 
    <div class="serchbaar">
            <form action="{{ route("admin.reports.participants") }}" method="GET" class="m-0" role="search">
                @csrf
                <div class="row">                    
                    {!!
                        Form::text('member', 'Participants', '')->size('col-sm-10')->id('member')->placeholder('Search Participant')
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
                        {{-- <th width="10">

                        </th> --}}
                        <th>
                            Participant name
                        </th>
                        <th>
                            NDIS number
                        </th>
                        <th>
                            Address / Support Location
                        </th>
                        <th>
                            Mobile number
                        </th>
                        <th>
                            Total funding allocated
                        </th>
                        <th>
                            Total funding left
                        </th>
                        <th>
                            Approved Registration groups 
                        </th>
                        {{-- <th>
                            Total funding allocated for each Registration group
                        </th>
                        <th>
                            Total funding left for each registration group
                        </th> --}}
                    </tr>
                </thead>
                @if($participants->isEmpty())

                <tbody>                   
                    <tr >
                        <td>
                            
                        </td> 
                        <td>
                            
                        </td> 
                        <td>
                            No participant found
                        </td> 
                        <td>
                            
                        </td> 
                        <td>
                            
                        </td> 
                    </tr>                
                </tbody>
                @else
                <tbody>
                    @foreach($participants as $key => $participant)
                    {{-- {{$participant}} --}}
                        <tr data-entry-id="{{ $participant->id }}">
                            <td>
                                <a class="" href="{{ route('admin.participants.edit', $participant->id) }}">
                                    {{ $participant->first_name ?? '' }}
                                    {{ $participant->last_name ?? '' }}
                                </a>
                            </td>
                            <td>
                                <a class="" href="{{ route('admin.participants.edit', $participant->id) }}">
                                    {{ $participant->ndis_number  ?? '' }}
                                </a>
                            </td>
                            <td>
                                {{ $participant->address ?? 'Not provided' }}
                            </td>
                            <td>
                                {{ $participant->mobile ?? 'Not provided' }}
                            </td>
                            <td>
                                {{ $participant->budget_funding ?? 'Not availbale' }}
                            </td>
                            <td>
                                {{ $participant->funds_balance ?? 'Not availbale' }}
                            </td>
                            <td>
                                
                                @foreach($participant->reg_groups as $key => $reg)
                                    {{ $reg->reg_group_id . ', '}}
                                @endforeach
                            </td>
                           
                        </tr>
                    @endforeach
                </tbody>
                @endif
            </table>

            @if( ! $participants->isEmpty() )
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