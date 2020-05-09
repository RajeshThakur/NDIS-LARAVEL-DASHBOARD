@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header"> 
        <div class="row">
            <div class="pageTitle">
                {{-- <h2>{{ trans('global.task.title_singular') ." ". trans('global.list') }}</h2> --}}
                <h2>Reports</h2>
            </div>
            <div class="icons ml-auto order-last">
                
            </div>
        </div>
    </div>

   <!--  <div class="card-body">
        <div class="report-list">
            <ul>
                <li>
                    <a href="{{ route('admin.reports.service-bookings')}}">Service Bookings By Time Period</a>
                </li>
                <li>
                    <a href="{{ route('admin.reports.participants')}}">Participants</a>
                </li>
                <li>
                    <a href="{{ route('admin.reports.participants.service-bookings')}}">Participant Bookings</a>
                </li>
                <li>                    
                    <a href="{{ route('admin.reports.support-workers.service-bookings')}}">Support Worker Bookings</a>
                </li>
                <li>
                    <a href="{{ route('admin.reports.service-bookings.funding')}}">Service Booking Fundings</a>
                </li>
                {{-- <li>
                    <a href="{{ route('admin.reports.support-workers')}}">Support Workers</a>
                </li> --}}
                
                <li>                    
                    <a href="{{ route('admin.reports.service-workers')}}">Service Workers</a>
                </li>
            </ul>
        </div>
    </div> -->

<div class="card-body" data-step="2" data-intro="List of All your existing participants">
        <div class="table-responsive cursor-custom">
            <table class=" table table-bordered table-striped table-hover datatable text-left reports-table">
                <thead>
                    <tr>
                        <th class="text-left">
                             Report List
                        </th>                      
                       
                    </tr>
                </thead>
                <tbody >                    
                    <tr>                       
                        <td class="text-left">
                             <a href="{{ route('admin.reports.service-bookings')}}">Service Bookings By Time Period</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left">
                            <a href="{{ route('admin.reports.participants')}}">Participants</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left">
                            <a href="{{ route('admin.reports.participants.service-bookings')}}">Participant Bookings</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left">                    
                            <a href="{{ route('admin.reports.support-workers.service-bookings')}}">Support Worker Bookings</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left">
                            <a href="{{ route('admin.reports.service-bookings.funding')}}">Service Booking Fundings</a>
                        </td>
                    </tr>
                    <tr>
                        {{-- <td>
                            <a href="{{ route('admin.reports.support-workers')}}">Support Workers</a>
                        </td> --}}
                    </tr>    
                        <td class="text-left">                    
                            <a href="{{ route('admin.reports.service-workers')}}">Service Workers</a>
                        </td>
                        
                    </tr>
                
                        
                </tbody>
            </table>
        </div>
    </div>
    
    
    {{-- <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('admin.reports.participants')}}">Participants</a>
        </div>
    </div>
        
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('admin.reports.participants.service-bookings')}}">Participant Bookings</a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('admin.reports.participants.funding')}}">Participant Fundings</a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('admin.reports.support-workers')}}">Support Workers</a>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('admin.reports.support-workers.service-bookings')}}">Support Worker Bookings</a>
        </div>
    </div> --}}
    

</div>
@endsection
@section('scripts')
@parent
<script>
   $(document).ready(function(){
  $(".tab-menu ul li a").click(function(){
    $(".tab-menu ul li a").removeClass("active");
          $(this).addClass("active");
  });
});
</script>
@endsection