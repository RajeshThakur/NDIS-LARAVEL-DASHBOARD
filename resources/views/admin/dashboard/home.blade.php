@extends('layouts.admin')
@section('libStyles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css" />
@endsection

@section('content')
<div class="content dashboard-first-list">
    <div class="front-page-design ">
        <div class="row full-width ml-0 mr-0">
            <div class="col-lg-12 pl-0 pr-0">
                <div class="melissa-parker">                    
                    <p class="welcome-text">{{ trans('global.dashboard_message', [ 'name' => Auth::user()->first_name." ".Auth::user()->last_name ]) }}</p>
                    <!-- <p class="update col-sm-4"><a href="#" class=""><img class="hide-active" src="/img/watch.png"></a>  {{ trans('global.Update_few_second_ago') }}</p> -->
                </div>
                <div class="dashboard-content">
                    <h3>{{ trans('global.feeds') }}</h3>
                    <div class="row feed">
                        <div class="col-sm-3 mobile-view">
                            <div class="dashboard-feeds pending-shift feedItem">
                            <a class="user feedbox" href="#" id="overdue" data-url="overdue-tasks">
                                <img class="hide-active" src="/img/arrow.png">
                                <img class="show-active" src="/img/active-arrow.png">
                                <p>{{ trans('global.my-overdue-tasks') }}</p>
                                <p class="mt-0">{{ trans('global.overdue-tasks') }}</p>
                            </a>
                            <p class="inactive-msg"><span>{{ $feedCount['overdues'] }}</span></p>
                                
                            </div>
                        </div>
                        <div class="col-sm-3 mobile-view">
                            <div class="dashboard-feeds participant-task feedItem">
                            <a class="user feedbox" href="#" id="upcoming-participant-sb" data-url="upcoming-partcipant-bookings">
                               <img class="hide-active" src="/img/participant.png">
                                <img class="show-active" src="/img/active-participant.png">
                                {{-- <p>Upcoming Participant <br>Service Bookings</p> --}}

                                <p>{{ trans('global.upcoming-dashboard') }}</p>
                                <p class="mt-0">{{ trans('global.service-upcoming-dashboard') }}</p>
                                </a>
                                <p class="inactive-msg"><span>{{ $feedCount['upcoming'] }}</span></p>
                            </div>
                        </div>
                        <div class="col-sm-3 mobile-view">
                            <div class="dashboard-feeds upcomming-training feedItem">
                            <a class="user feedbox" href="#" id="incomplete-sb" data-url="incomplete-bookings">
                                <img class="hide-active" src="/img/upcoming.png">
                                <img class="show-active" src="/img/active-upcoming.png">
                                {{-- <p>Incomplete<br>Service Bookings</p> --}}
                                <p>{{ trans('global.incomplete') }}</p>
                                <p class="mt-0">{{ trans('global.incomplete-booking') }}</p>
                                </a>
                                <p class="inactive-msg"><span>{{ \App\Bookings::where('booking_orders.status','=',config('ndis.booking.statuses.NotSatisfied'))->count() }}</span></p>
                            
                            </div>
                        </div>
                        <div class="col-sm-3 mobile-view">
                            <div class="dashboard-feeds participant-allocated feedItem">
                                <a class="user feedbox" href="#" id="partcipants-without-sb" data-url="partcipants-without-booking">
                                <img class="hide-active" src="/img/allocated.png">
                                <img class="show-active" src="/img/active-allocated.png">
                                {{-- <p>Participants Without<br>Service Bookings</p> --}}
                                <p>{{ trans('global.dashboard-participant') }}</p>
                                <p class="mt-0">{{ trans('global.dashboard-without-booking') }}</p>
                                </a>
                                <p class="inactive-msg"><span>{{ $feedCount['without'] }}</span></p>
                                
                            </div>
                        </div>
                    </div>
                    <div class="feed-data">
                        
                    </div>
                </div> 

                <div class="row mr-0 ml-0">
                    <div class="col-sm-12 dashboard-content border-none">               
                        <div class="row full-width ml-0 mr-0 mt-3">
                                <div class="card">
                                    <div class="card-header">
                                        {{ trans('global.tasksCalendar.title') }}
                                    </div>                        
                                    <div class="card-body">

                                        <div class="row">
                                            
                                            <div class="col-sm-9 mobile-view calendar-dashboard">
                                                <div class="pr-3">
                                                    <div id="calendar"></div>
                                                    <div class="multi-events" style="display:none"></div>    
                                                </div>
                                            </div>

                                            <div class="col-sm-3 mobile-view mr-0 pr-0">
                                                <div class="main-edit">
                                                    <div class="creat-event-heading">
                                                        <h2> {{ trans('global.events') }}</h2>
                                                    </div>
                                                    
                
                                                    <div class="creat-event">
                                                        <a href="{{route('admin.events.create')}}">
                                                            <span class="fa fa-plus"></span>
                                                            <p><span>{{ trans('global.create-event') }}</span></p>
                                                        </a>
                                                    </div>
                                                    <div class="edit-event">
                                                        <a href="{{route('admin.events.index')}}">
                                                            <span class="fa fa-calendar-o"></span>
                                                            <p> <span>{{ trans('global.view-all') }}</span></p>
                
                                                        
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                
                                    </div>
                                
                            </div>
                                        
                        </div>        
                    </div>
                </div>
            </div>
        </div>        
    </div>
@endsection
@section('scripts')
@parent
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
<script>
    $(document).ready(function() {
        var time = {'new': '', 'old':''};
        // page is now ready, initialize the calendar...
        $('#calendar').fullCalendar({
            // put your options and callbacks here
            // plugins: [ interactionPlugin ],
            droppable: true,
            editable: true,
            // eventLimit: 2,
            // eventStartEditable: true,
            events : [
                        @foreach($events as $event)                                
                            @if($event->due_date)
                                {
                                    id: '{{ $event->id }}',
                                    className: '{{ $event->multi }}',
                                    title : '{{ $event->name }}',
                                    start : '{{ dateToDB($event->due_date) }}',
                                    url : "{{ route('admin.events.edit', [$event->id]) }}",
                                    color: '{{ strtolower(\App\Colors::find($event->color_id)->name) }}',
                                    editable: true,
                                    startEditable: true
                                },
                            @endif
                        @endforeach
                    ],
            eventRender: function(event, eventElement) {
                        time.new = event.start.format();
                        $color = eventElement.attr('style');
                        $thead = $('.fc-content-skeleton')
                                    .find(`[data-date='${event._start._i}']`);
                        $thead.addClass('event-td-head')
                                .children('span')
                                    .addClass('event-td-head-span')
                                    // .attr('style',eventElement.attr('style'));
                                        // .hide();
                        eventElement.text($thead.text());
                        if( event.start.format() == time.old ){
                            eventElement.hide();
                        }
                        time.old = event.start.format();
                    },
            eventDrop: function(event, delta, revertFunc, jsEvent, ui, view) {
                $droppedOnDate = event.start.format('');
                $id = event.id;
            
                // revert if multi events are dragged
                if($(this).hasClass('multi')){
                    alert("Cannot drag drop multi events");
                    revertFunc();
                }
                else
                {
                    // console.log(event);
                    // hide date on which event is dropped
                    // $('.fc-content-skeleton')
                    //   .find(`[data-date='${event.start.format()}']`)
                    //     .hide();
                    $class="single";
                    $('#calendar').fullCalendar('clientEvents', function(e) {  
                        if($droppedOnDate == e.start._i){
                            $class="multi";
                            e.className = "multi";
                            $('#calendar').fullCalendar('updateEvent', e);
                        }
                    });
                    $('#calendar').fullCalendar('clientEvents', function(e) {
                        
                        if(e.id == $id ) {
                        // if( $droppedOnDate == e.start._i ) {
                            // alert("Dropped on: "+ $droppedOnDate + "  Currentloopdate: " + e.start._i +" Classname: "+ $class )
                            $newEvent = [{
                                            id: $id,
                                            className: $class,
                                            title : e.title,
                                            start : $droppedOnDate,
                                            url : e.url,
                                            color: e.color,
                                            editable: true,
                                            startEditable: true
                                        }];
                            // console.log($newEvent );
                            //update date 
                            ndis.ajax(
                                '/admin/update-event-date',
                                'POST',
                                {id:$id,date:$droppedOnDate},
                                function(data){
                                    if(data.status){
                                    //    console.log("After ajax : " + $newEvent[0].className);
                                        $('#calendar').fullCalendar( 'removeEvents', [$id] );
                                        $('#calendar').fullCalendar( 'addEventSource',  $newEvent);
                                        alert('Event date changed !')
                                    }
                                    else{
                                        alert('Some error while changing event date !');
                                        revertFunc();
                                    }
                                        
                                },
                                function(err){
                                    alert('Some error while changing event date !');
                                    revertFunc();
                                },
                            );
                        }
                    });
                }
            },
            eventClick: function(calEvent, jsEvent, view) {
                // console.log(this);
                $('.multi-events').remove();
                $date = calEvent.start.format();
                $html = '';
                $html += '<div class="multi-events">';
                
                if($(this).hasClass('multi')){
                    $('#calendar').fullCalendar('clientEvents', function(event) {
                        if(event.start.format() == $date ) {
                            $html += '<div class="pop-design"><a style="border-left:4px '+event.color+' solid;color:white;padding:5px 10px;display:block;" href="' + event.url + '">' + event.title + '</a></div>';
                        }
                    });
                    $html += '<a class="multi-close"><i class="fa fa-close"></i></a>';
                    $html += '</div>';
                    // $('.multi-events').empty();
                    // $('.multi-events').append($html);
                    // $('.multi-events').show();
                    $(this).after($html);
                    return false;
                }
                if( $(this).hasClass('single')){
                    return true;
                }
            },
            eventAfterAllRender: function(){                    
                time = {'new': '', 'old':''};
            }
            
        })
        
        $(document).on("click", "a.multi-close" , function(e) {
            e.preventDefault();
            // console.log($('.multi-events'));
            // $('.multi-events').empty().hide();
            $('.multi-events').remove();
        });
        
        $("a.user.feedbox").click(function(){
            $('a.user.feedbox').parent('.active').removeClass('active');
            var elem = $(this);
            // console.log(elem);
            elem.parent().addClass('active');                
            $url = elem.data('url');
            $('.feed-data').empty();
            // if(elem.hasClass('active')) return;
            ndis.addLoader( elem );
            
            ndis.ajax(
                '/admin/'+$url,
                'GET',
                '',
                function(data){
                    if(data.status){ //if any row
                        // console.log(data.msg);
                        elem.addClass('active')
                        ndis.removeLoader( elem );
                        $('.feed-data').empty().html(data.msg);
                    }else{ //if empty
                        // console.log(data.msg);
                        elem.addClass('active')
                        ndis.removeLoader( elem );
                        $('.feed-data').empty().html(data.msg);
                    }
                    
                },
                function(err){
                    
                    // console.log(err);
                    elem.addClass('active')
                    ndis.removeLoader( elem );
                },
            );
        });
        $('button.fc-prev-button').on('click', function(){
            $(this).addClass('fc-open');
                $('button.fc-next-button').removeClass('fc-open');
            });
        $('button.fc-next-button').on('click', function(){
            $(this).addClass('fc-open');
            $('button.fc-prev-button').removeClass('fc-open');
        });
    });
</script>



@endsection