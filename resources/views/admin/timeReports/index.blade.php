@extends('layouts.admin')
@section('content')
<h3 class="page-title">{{ trans('global.reports') }}</h3>

<form method="get">
    <div class="row">

        {!! 
            Form::date('from', trans('global.timeFrom'), old('from', request()->get('from', date('Y-m-d'))))->id('from')->size('col-sm-2') 
        !!}
        {{-- <div class="col-2 form-group">
            <label for='from' class='control-label',>{{ trans('global.timeFrom') }}</label>
            <input type="text" id="from" name="from" class="form-control datefield"  data-toggle="datetimepicker" data-target="#from" value="{{ old('from', request()->get('from', date('Y-m-d'))) }}">
        </div> --}}
        {!! 
            Form::datetime('to', trans('global.timeTo'), old('to', request()->get('to', date('Y-m-d'))))->id('to')->size('col-sm-6') 
        !!}

        {{-- <div class="col-2 form-group">
            <label for='to' class='control-label'>{{ trans('global.timeTo') }}</label>
            <input type="text" id="to" name="to" class="form-control datefield"  data-toggle="datetimepicker" data-target="#to" value="{{ old('to', request()->get('to', date('Y-m-d'))) }}">
        </div> --}}
        
        <div class="col-4">
            <label class="control-label">&nbsp;</label><br>
            <button type="submit" class="btn btn-primary">{{ trans('global.filterDate') }}</button>
        </div>
    </div>
</form>
<div class="card">
    <div class="card-header">
        {{ trans('global.timeReport.reports.timeEntriesReport') }}
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>{{ trans('global.timeReport.reports.timeByProjects') }}</th>
                        <th></th>
                    </tr>
                    @foreach($projectTimes as $projectTime)
                        <tr>
                            <th>{{ $projectTime['name'] }}</th>
                            <td>{{ gmdate("d H:i:s", $projectTime['time']) }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="col">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>{{ trans('global.timeReport.reports.timeByWorkType') }}</th>
                        <th></th>
                    </tr>
                    @foreach($workTypeTime as $workType)
                        <tr>
                            <th>{{ $workType['name'] }}</th>
                            <td>{{ gmdate("d H:i:s", $workType['time']) }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
@stop