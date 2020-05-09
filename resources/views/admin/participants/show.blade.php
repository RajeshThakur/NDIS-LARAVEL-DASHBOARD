@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('participants.title') }}
    </div>

    <div class="card-body">
        <div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('participants.fields.first_name') }}
                        </th>
                        <td>
                            {{ $participant->user->first_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('participants.fields.last_name') }}
                        </th>
                        <td>
                            {{ $participant->user->last_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('participants.fields.email') }}
                        </th>
                        <td>
                            {{ $participant->user->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('participants.fields.address') }}
                        </th>
                        <td>
                            {{ $participant->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('participants.fields.start_date_ndis') }}
                        </th>
                        <td>
                            {{ $participant->start_date_ndis }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('participants.fields.end_date_ndis') }}
                        </th>
                        <td>
                            {{ $participant->end_date_ndis }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('participants.fields.ndis_number') }}
                        </th>
                        <td>
                            {{ $participant->ndis_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('participants.fields.participant_goals') }}
                        </th>
                        <td>
                            {{ $participant->participant_goals }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('participants.fields.special_requirements') }}
                        </th>
                        <td>
                            {!! $participant->special_requirements !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-primary rounded" href="{{ url()->previous() }}">
                Back
            </a>
        </div>
    </div>
</div>

@endsection