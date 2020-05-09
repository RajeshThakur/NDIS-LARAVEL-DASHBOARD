<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskStatusRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\TaskStatus;

class TaskStatusController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('task_status_access'), 403);

        $taskStatuses = TaskStatus::all();

        return view('admin.taskStatuses.index', compact('taskStatuses'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('task_status_create'), 403);

        return view('admin.taskStatuses.create');
    }

    public function store(StoreTaskStatusRequest $request)
    {
        abort_unless(\Gate::allows('task_status_create'), 403);

        $taskStatus = TaskStatus::create($request->all());

        return redirect()->route('admin.events.statuses.index')->with('success', trans('msg.status_list_add.success') );
    }

    public function edit(TaskStatus $taskStatus)
    {
        abort_unless(\Gate::allows('task_status_edit'), 403);

        return view('admin.taskStatuses.edit', compact('taskStatus'));
    }

    public function update(UpdateTaskStatusRequest $request, TaskStatus $taskStatus)
    {
        abort_unless(\Gate::allows('task_status_edit'), 403);

        $taskStatus->update($request->all());

        return redirect()->route('admin.events.statuses.index')->with('success', trans('msg.status_list_update.success') );
    }

    public function show(TaskStatus $taskStatus)
    {
        abort_unless(\Gate::allows('task_status_show'), 403);

        return view('admin.taskStatuses.show', compact('taskStatus'));
    }

    public function destroy(TaskStatus $taskStatus)
    {
        abort_unless(\Gate::allows('task_status_delete'), 403);

        $taskStatus->delete();

       // return back();
         $taskStatus = taskStatus::all();

        //$taskStatus->load('user');
        // return back();
        return redirect()->route('admin.events.statuses.index')->with('success', trans('msg.status_list_delete.success'));
    }


}
