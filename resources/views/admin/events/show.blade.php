@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('global.task.title') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('global.task.fields.name') }}
                    </th>
                    <td>
                        {{ $task->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.task.fields.description') }}
                    </th>
                    <td>
                        <ul>@php 
                            foreach(unserialize($task->description) as $key=>$val){
                                echo "<li>";
                                echo $val;
                                echo "</li>";
                            } 
                            @endphp
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.task.fields.status') }}
                    </th>
                    <td>
                        {{ $task->status->name ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Tags
                    </th>
                    <td>
                        @foreach($task->tags as $id => $tag)
                            <span class="label label-info label-many">{{ $tag->name }}</span>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.task.fields.attachment') }}
                    </th>
                    <td>
                        {{ $task->attachment }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.task.fields.due_date') }}
                    </th>
                    <td>
                        {{ $task->due_date }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.task.fields.assigned_to') }}
                    </th>
                    <td>
                        {{ $task->assigned_to->name ?? '' }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection