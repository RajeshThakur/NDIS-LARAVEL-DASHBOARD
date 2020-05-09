@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            
                <div class="ac-parker mt-2 row">

                    <p class="welcome-text col-sm-8">{{ trans('global.dashboard_message', [ 'name' => Auth::user()->first_name." ".Auth::user()->last_name ]) }}</p>
                    <!-- <p class="update col-sm-4"><a href="#"><span class="icon-alarmclock"></span></a>{{ trans('global.Accounts_External_Service_timesheet.Update_few_second_ago') }}</p> -->
                </div>
        </div>
                <div class="row">                    
                    <div  class="col-sm-12 mt-5 ">
                        <div class="form-group {{$type}}" id="service_type_selector">
                        <div class="input-group drop-down-accounts" data-type="{{$type}}">

                            <input id="toggle-on" class="toggle toggle-left service_type" name="service_type" value="support_worker" type="radio" @if ($type=='support') checked @endif >
                            <label for="toggle-on" class="toggle-label col-6 caret-icon-left">Support Worker</label>
                            <input id="toggle-off" class="toggle toggle-right service_type" name="service_type" value="external_service" type="radio" @if ($type=='external') checked @endif>
                            <label for="toggle-off" class="toggle-label col-6 caret-icon-right">External Service</label>
                            <div class="ac-selector href-list worker-on" style="">

                            <ul class="none-before">
                                <li class="timesheet">
                                     <a href="{{ route("admin.accounts.timesheet", $type) }}" class="tab-a {{ $activeTabInfo['tab'] == 'timesheet'? 'active-a '.$type:'' }}" data-id="tab1">
                                        Timesheet
                                    </a>
                                </li>
                                <li class="submission">
                                    <a href="{{ route("admin.accounts.submission", $type) }}" class="tab-a {{ $activeTabInfo['tab'] == 'submissions'? 'active-a '.$type:'' }}" data-id="tab2">
                                        Submissions
                                    </a>
                                </li>
                                <li class="payment">
                                    <a href="{{ route("admin.accounts.payments", $type) }}" class="tab-a {{ $activeTabInfo['tab'] == 'payments'? 'active-a '.$type:'' }}" data-id="tab3">
                                        Payment History
                                    </a>
                                </li>
                                <li class="proda">
                                    <a href="{{ route("admin.accounts.proda", $type) }}" class="tab-a {{ $activeTabInfo['tab'] == 'proda'? 'active-a '.$type:'' }}" data-id="tab4">
                                        PRODA Output
                                    </a>
                                </li>
                            </ul>
                        </div>
                        </div>
                        <small class="form-text text-muted">&nbsp;</small>
                        </div>
                        
                        


                            </div>
                            <small class="form-text text-muted">&nbsp;</small>
                        </div>
                        
                        


                        {{-- <div class="tab-menu">
                            <ul>
                                <li>
                                    <a href="{{ route("admin.accounts.worker.timesheet") }}" class="tab-a {{ $activeTabInfo['tab'] == 'timesheet'? 'active-a':'' }}" data-id="tab1">
                                        Timesheet
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route("admin.accounts.worker.submission") }}" class="tab-a {{ $activeTabInfo['tab'] == 'submissions'? 'active-a':'' }}" data-id="tab2">
                                        Submissions
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route("admin.accounts.worker.payments") }}" class="tab-a {{ $activeTabInfo['tab'] == 'payments'? 'active-a':'' }}" data-id="tab3">
                                        Payment History
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route("admin.accounts.worker.proda") }}" class="tab-a {{ $activeTabInfo['tab'] == 'proda'? 'active-a':'' }}" data-id="tab4">
                                        PRODA Output
                                    </a>
                                </li>
                                
                            </ul>
                        </div> --}}

                        @include($activeTabInfo['file'])

                    </div>
                </div>

                <!-- card-body start -->
                {{-- <div class="card-body">
                    <div class="table-responsive cursor-custom">
                        <table class=" table table-bordered table-striped table-hover datatable">
                            <thead>
                                <tr>
                                    <th width="10"></th>
                                    <th>
                                        {{ trans('participants.fields.first_name') }}
                                    </th>
                                    <th>
                                        {{ trans('participants.fields.last_name') }}
                                    </th>
                                    <th>
                                        {{ trans('participants.fields.email') }}
                                    </th>
                                    {{-- <th>&nbsp;</th> --}}
                                {{-- </tr>
                            </thead>
                            <tbody>
                                @if( count($data) )
                                    @foreach($data as $key => $participant)
                                        <tr data-entry-id="{{ $participant->user_id }}">
                                            <td></td>
                                            <td>
                                                <a class="icon" href="{{ route('admin.data.edit', $participant->user_id) }}">
                                                    {{ $participant->first_name ?? '' }}
                                                </a>
                                            </td>
                                            <td>
                                                <a class="icon" href="{{ route('admin.data.edit', $participant->user_id) }}">{{ $participant->last_name ?? '' }}</a>
                                            </td>
                                            <td></td>>
                                                <a class="icon" href="{{ route('admin.data.edit', $participant->user_id) }}">{{ $participant->email ?? '' }}</a>
                                            </td>
                                            {{-- <td></td> --}}
                                        {{-- </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td></td>
                                        <td colspan="3" class="text-center">
                                            No Records Found!
                                        </td>

                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div> --}}
                <!-- card-body end -->

                {{-- <div class="account-sub-button">
                    <div class="create-new edit-new participant-notes">
                        <ul>
                            <li><button class="btn btn-primary btn btn-primary  plr-100 rounded" type="submit">Print</button></li>
                            <li><button class="btn btn-primary btn btn-secondary plr-100 ml-30 rounded download" type="submit">Download <span><i class="fa fa-download" aria-hidden="true"></i></span>
                                </button>
                                <ul class="show-list">
                                    <li><a href="#">Demo 1</a></li>
                                    <li><a href="#">Demo 2 </a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div> --}}
    </div>


@endsection
@section('scripts')
@parent
<script>


</script>
<script>
    $(document).ready(function() {

        
        var type = $('div.drop-down-accounts').data('type');
        // console.log($('div.drop-down-accounts').data('type'));

        if(type == 'external'){
            $('#toggle-on').siblings('label.caret-icon-left').removeClass('worker-on');
            $('#toggle-off').siblings('label.caret-icon-right').addClass('worker-on');
            $("#toggle-off").trigger("click");
        }else{
            $('#toggle-on').siblings('label.caret-icon-left').addClass('worker-on');
            $('#toggle-off').siblings('label.caret-icon-right').removeClass('worker-on');
            $("#toggle-on").trigger("click");
        }

        $('#toggle-on').on('click', function(e) {   

            $('#service_type_selector').removeClass('external');
            $('#service_type_selector').addClass('support');
            
            $( $('div.href-list ul li') ).each(function( index, val ) {
                if($(this).hasClass('timesheet'))
                    $(this).children('a').attr('href', "{{URL::to('admin/accounts/support/timesheet')}}" );

                if($(this).hasClass('submission'))
                    $(this).children('a').attr('href', "{{URL::to('admin/accounts/support/submission')}}" );

                if($(this).hasClass('payment'))
                    $(this).children('a').attr('href', "{{URL::to('admin/accounts/support/payments')}}" );

                if($(this).hasClass('proda'))
                    $(this).children('a').attr('href', "{{URL::to('admin/accounts/support/proda')}}" );
            });        


            $(".ac-selector").css({"position":"","right":""});
            $(".ac-selector").css({"position":"absolute","left":"18%","top":"70px","width":"200px"});

            $('#toggle-on').siblings('label.caret-icon-left').addClass('worker-on');
            $('#toggle-off').siblings('label.caret-icon-right').removeClass('worker-on');
            window.location.href = '{{route("admin.accounts.timesheet", "support")}}'; 

        });

        $('#toggle-off').on('click', function(e) {           
            
            $('#service_type_selector').removeClass('support');
            $('#service_type_selector').addClass('external');
             
            $( $('div.href-list ul li') ).each(function( index, val ) {
                if($(this).hasClass('timesheet'))
                    $(this).children('a').attr('href', "{{URL::to('admin/accounts/external/timesheet')}}" );

                if($(this).hasClass('submission'))
                    $(this).children('a').attr('href', "{{URL::to('admin/accounts/external/submission')}}" );

                if($(this).hasClass('payment'))
                    $(this).children('a').attr('href', "{{URL::to('admin/accounts/external/payments')}}" );

                if($(this).hasClass('proda'))
                    $(this).children('a').attr('href', "{{URL::to('admin/accounts/external/proda')}}" );
            });

            $('#toggle-on').siblings('label.caret-icon-left').removeClass('worker-on');
            $('#toggle-off').siblings('label.caret-icon-right').addClass('worker-on');
            

            $(".ac-selector").css({"position":"","left":""});
            $(".ac-selector").css({"position":"absolute","right":"18%","top":"70px","width":"200px"});
            window.location.href = '{{route("admin.accounts.timesheet", "external")}}';
        }); 


        $("button.download").click(function(){
            $("ul.show-list").toggle();
        });

        // $("label.toggle-label").click(function(){
        //     $("this").addClass("active-menu");
        // });

        //  $("label.toggle-label").click(function(){
        //     $(".active-menu").show();
        // });

        // $("label.toggle-label").click(function () {
        //     $("label.toggle-label").removeClass("active");
        //     $("label.toggle-label").addClass("active");        
        // });

        // $("label.toggle-label").click(function(){
        //     $(".ac-selector.active ul.none-before").show();
        // });
        // $("#toggle-on").trigger("click");

        jQuery("body").on("mouseout", ".worker-on", function() {

          $( ".ac-selector" ).css("display", "none");
         
        });

        jQuery("body").on("mouseover", ".worker-on", function() {

          $( ".ac-selector" ).css("display", "block");
         
        });

        

    });

    
</script>
@endsection