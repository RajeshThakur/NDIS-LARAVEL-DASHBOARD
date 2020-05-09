@extends('layouts.admin')
@section('content')
<div class="card">
     <div class="card-header">
        <div class="row">
            <div class="pageTitle">
                <h2>{{ trans('search.title') }}</h2>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('search.fields.first_name') }}
                        </th>
                        <th>
                            {{ trans('search.fields.last_name') }}
                        </th>
                        <th>
                            {{ trans('search.fields.email') }}
                        </th>
                        <th>
                            {{ trans('search.fields.role') }}
                        </th>
                        {{-- <th>
                            &nbsp;
                        </th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($searchedData as $key => $result)
                        @if(isset($result['UserProvider'][0]))
                            <tr data-entry-id="{{ $result['id'] }}">
                                <td>

                                </td>
                                <td>
                                    <a class="icon" href="{{ (isset($result['role'])) ? route($result['href_link'], $result['id']): '#' }}">{{ $result['first_name'] ?? '' }}</a>
                                </td>
                                <td>
                                    <a class="icon" href="{{ (isset($result['role'])) ? route($result['href_link'], $result['id']): '#' }}">{{ $result['last_name'] ?? '' }}</a>
                                </td>
                                <td>
                                    <a class="icon" href="{{ (isset($result['role'])) ? route($result['href_link'], $result['id']): '#' }}">{{ $result['email'] ?? '' }}</a>
                                </td>
                                <td>
                                    <a class="icon" href="{{ (isset($result['role'])) ? route($result['href_link'], $result['id']): '#' }}">{{ $result['role'] ?? '' }}</a>
                                </td>
                            </tr>
                        @endif
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

 
    })

</script>
@endsection