@extends('layouts.admin')

@section('content')
    @include('admin.messenger.partials.flash')

    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="pageTitle">
                    <h2>{{ trans('global.inbox') }}</h2>
                </div>
                <div class="icons ml-auto order-last" id="intro_step1"  data-intro="Add to create New Message">
                    <a class="btn btn-success rounded"  href="{{ route("admin.messages.create") }}">
                        {{ trans('global.new_message') }}
                    </a>
                </div>
            </div>
        </div>
    
    <div class="serchbaar mt-4" data-step="3"  data-intro="Add to create New Message">
        <form action="{{ route("admin.messages.index") }}" method="GET" class="m-0" role="search">

            <div class="input-group">
                {!! 
                    Form::text('q',  '', '' )->placeholder('Search Messages')->attrs(["class"=>"badge-pill bg-white"])
                !!}
                 <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"><img class="search" src="{{url('img/search.png')}}" alt="NDIS" /></span>
                    </button>
                </span>
            </div>

        </form>
    </div>

    <div class="card-body" data-step="2" data-intro="Chouse any list">

            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable">
                    <thead>
                        <tr>
                            <th width="10">
                                {{ trans('global.messaging.fields.number') }}
                            </th>
                            <th>
                                {{-- {{ trans('global.messaging.fields.message') }} --}}
                                {{ trans('global.messaging.fields.subject') }}
                            </th>
                            <th>
                                {{ trans('global.messaging.fields.sender') }}
                            </th>
                            <th>
                                {{ trans('global.messaging.fields.date') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>  
                        {{-- @each('admin.messenger.partials.thread', $threads, 'thread', 'admin.messenger.partials.no-threads') --}}
                        <?php $count = 0; ?>
                        @if (count($threads))
                            @foreach ($threads as $thread)
                                @include('admin.messenger.partials.thread', array($thread  ,$count++))
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">
                                    <p class="text-center">Sorry, no threads.</p>
                                </td>
                            </tr>
                        @endif
                        
                    </tbody>
                </table>
            </div>
        </div>

@stop

@section('scripts')
@parent
<script>
    $(function () {
        
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons });
    })

    

</script>
@endsection
