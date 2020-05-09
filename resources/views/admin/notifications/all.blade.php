@extends('layouts.admin')
@section('content')
<div class="content dashboard-first-list">
    <div class="front-page-design ">
        <div class="row full-width ml-0 mr-0">
            <div class="col-lg-12 pl-0 pr-0">
                <div class="melissa-parker row">                    
                    <p class="welcome-text col-sm-8">{{ trans('global.all')." ".trans('global.notifications')." ".trans('global.list') }}</p>
                    <!-- <p class="update col-sm-4"><a href="#" class=""><img class="hide-active" src="/img/watch.png"></a>  {{ trans('global.Update_few_second_ago') }}</p> -->
                </div>
            </div>
        </div>
        
        

        {{-- <div class="notifications mt-5  ml-4 mr-4">
            <div class="row">
                <div class="col-lg-12"> --}}
                    <div class="mt-3 ml-3 mr-3">
                <table class="table-responsive datatable hide-table-head">
                    <thead>
                        <th>&nbsp;</th>
                    </thead>
                    <tbody>
                        
                            
                    @foreach ($noifications as $noification)
                    <tr>
                        <td>
                            <div class="callout callout-info notifi">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                
                                <span class="close-notification delete-record" data-id="{{ $noification->id }}"><i class="fa fa-times" aria-hidden="true"></i></span>
                                <h5>
                                    <a href="{{$noification->data['link']}}">
                                        {{$noification->data['text']}}
                                    </a>
                                </h5>
                                
                                {{-- <button class="delete-record" data-id="{{ $noification->id }}" >Delete Record</button> --}}
        
                                <small>{{$noification->data['details']}}</small><br>
                                <small>{{ $noification->created_at->diffForHumans() }}</small>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                           
                    </tbody>

                </table>
                    </div>
                    

                {{-- </div>
            </div>

        </div> --}}

    </div>
@endsection
@section('scripts')
@parent
<script>

    $(".delete-record").click(function(){

        var that = $(this);
        var id = $(this).data("id");
        var token = $("meta[name='csrf-token']").attr("content");
    
        $.ajax(
        {
            url: "notification/"+id,
            type: 'DELETE',
            data: {
                "id": id,
                "_token": token,
            },
            success: function (){
               that.parent('.notifi').remove();
            }
        });
    
    });

    $(function () {

    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons });
    console.log($('.datatable:not(.ajaxTable)'));

    })

    $(document).ready(function() {
    });
</script>



@endsection