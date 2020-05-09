@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('global.registrationGroup.title') }}
    </div>

    <div class="card-body">
        <div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('global.registrationGroup.fields.title') }}
                        </th>
                        <td>
                            {{ $registrationGroup->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('global.registrationGroup.fields.status') }}
                        </th>
                        <td>
                            {{ App\RegistrationGroup::STATUS_SELECT[$registrationGroup->status] }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                Back
            </a>
        </div>
    </div>
</div>

@endsection