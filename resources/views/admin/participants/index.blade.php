@extends('layouts.admin')
@section('content')

<div class="card">
    
    <div class="card-header mb-4">
        <div class="row">
            <div class="pageTitle">
                <h2>{{ trans('participants.title_singular') }} {{ trans('global.list') }}</h2>
            </div>
            @php if( !checkUserRole('1') ): @endphp
            <div class="icons ml-auto order-last" id="intro_step1"  data-intro="Add Participant Using this Button">
                @can('participant_create')
                    <a class="btn btn-success hint_top rounded" aria-label="{{ trans('global.add') }} {{ trans('participants.title_singular') }}" href="{{ route("admin.participants.create") }}">
                        {{ trans('global.add') }} {{ trans('participants.title_singular') }}
                    </a>
                @endcan
            </div> 
        @php endif; @endphp
        </div>
    </div>

    {{-- <div class="Search-Results">
        <h2>Search Results</h2>
    </div> --}}
    
    <div class="serchbaar mt-3" data-step="3"  data-intro="Filter Participants by First/Last name or Email" >
        <form action="{{ route("admin.participants.index") }}" method="GET" class="m-0" role="search">
            <div class="input-group">
                <input type="text" class="form-control external-service  badge-pill bg-white" name="q" value="{{$query}}" placeholder="First Name, Last Name or Email" />
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"><img class="search" src="{{url('img/search.png')}}" alt="NDIS" /></span>
                    </button>
                </span>
            </div>
        </form>
    </div>

    <div class="card-body mt-3" data-step="2" data-intro="List of All your existing participants">
        <div class="table-responsive cursor-custom">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>
                            {{ trans('participants.fields.first_name') }}
                        </th>
                        <th>
                            {{ trans('participants.fields.last_name') }}
                        </th>
                        <th>
                            {{ trans('participants.fields.email') }}
                        </th>
                        <th>
                            {{ trans('participants.fields.address') }}
                        </th>
                        <th>
                            {{ trans('participants.onboarding.fields.completed') }}
                        </th>
                        <th>
                            {{ trans('global.active') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if( count($participants) )
                        @foreach($participants as $key => $participant)
                            <tr data-href="{{ route('admin.participants.edit', $participant->id) }}" data-entry-id="{{ $participant->id }}">
                                <td>
                                    <a class="icon" href="{{ route('admin.participants.edit', $participant->id) }}">
                                        {{ $participant->first_name ?? '' }}
                                    </a>
                                </td>
                                <td>
                                    <a class="icon" href="{{ route('admin.participants.edit', $participant->id) }}">{{ $participant->last_name ?? '' }}</a>
                                </td>
                                <td>
                                    <a class="icon" href="{{ route('admin.participants.edit', $participant->id) }}">{{ $participant->email ?? '' }}</a>
                                </td>
                                <td>
                                    {{ $participant->address ?? '' }}
                                </td>
                                <td class="">
                                    {{ $participant->is_onboarding_complete ? 'Yes': 'No' }}
                                </td>
                                <td class="text-right">                                 
                                    @if($participant->active )
                                    <span class="activate-yes">Yes</span>
                                    @else
                                    <a class="resend_email" data-id="{{ $participant->user_id }}">{{ trans('global.resend_activation_mail')  }}</a> 
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">
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

        var introGiven = localStorage.getItem("participant_intro_given");
            if(!introGiven){
                introJs().start();
                localStorage.setItem("participant_intro_given", true);
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
  
    });

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