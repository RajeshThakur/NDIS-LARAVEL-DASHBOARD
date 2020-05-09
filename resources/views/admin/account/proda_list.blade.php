
<form action="#" method="POST" enctype="multipart/form-data">

    @csrf

    @method('PUT')

    <div class="card-body mt-2">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                       <th>
                            {{ trans('accounts.headings.id') }}
                        </th>
                        <th>
                            {{ trans('accounts.headings.title') }}
                        </th>
                        <th>
                            {{ trans('accounts.headings.created') }}
                        </th>                            
                        <th>
                            {{ trans('accounts.headings.updated') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if($records->count())
                        @foreach($records as $key => $proda)
                            @if($proda->service_type == 'true')
                                <tr data-entry-id="{{ $proda->id }}">

                                    <td>    
                                        <a href="{{ route("admin.accounts.getTimesheet", array($proda->id, $type) ) }}">{{ $key+1 }}</a>
                                    </td>

                                    <td>    
                                        <a href="{{ route("admin.accounts.getTimesheet", array($proda->id, $type) ) }}">{{ $proda->title }}</a>
                                    </td>

                                    <td>    
                                        <a href="{{ route("admin.accounts.getTimesheet", array($proda->id, $type)) }}">{{ dbToDatetime($proda->created_at) }}</a>
                                    </td>

                                    <td>    
                                        <a href="{{ route("admin.accounts.getTimesheet", array($proda->id, $type)) }}">{{ dbToDatetime($proda->updated_at) }}</a>
                                    </td>

                                </tr>
                            @endif
                         @endforeach
                      @else
                        <tr>
                            <td colspan="8" class="text-center">
                                You’re all up to date
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- {!! 
        Form::submit('Paid')->attrs(["class"=>"btn btn-primary rounded ml-30"]) 
    !!} --}}
</form>

@section('scripts')
@parent
<script>
    $(function () {
        
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons });
    
    })
</script>
@endsection