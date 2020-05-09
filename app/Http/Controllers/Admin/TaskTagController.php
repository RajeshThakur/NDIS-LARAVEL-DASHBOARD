<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskTagRequest;
use App\Http\Requests\UpdateTaskTagRequest;
use App\TaskTag;

class TaskTagController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('task_tag_access'), 403);

        $taskTags = TaskTag::all();

        return view('admin.taskTags.index', compact('taskTags'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('task_tag_create'), 403);

        return view('admin.taskTags.create');
    }

    public function store(StoreTaskTagRequest $request)
    {
        abort_unless(\Gate::allows('task_tag_create'), 403);

        $taskTag = TaskTag::create($request->all());

        return redirect()->route('admin.task-tags.index')->with('success',  trans('msg.task_tag_add.success') );
    }

    public function edit(TaskTag $taskTag)
    {
        abort_unless(\Gate::allows('task_tag_edit'), 403);

        return view('admin.taskTags.edit', compact('taskTag'));
    }

    public function update(UpdateTaskTagRequest $request, TaskTag $taskTag)
    {
        abort_unless(\Gate::allows('task_tag_edit'), 403);

        $taskTag->update($request->all());

        return redirect()->route('admin.task-tags.index')->with('success',  trans('msg.task_tag_update.success') );
    }

    public function show(TaskTag $taskTag)
    {
        abort_unless(\Gate::allows('task_tag_show'), 403);

        return view('admin.taskTags.show', compact('taskTag'));
    }

    public function destroy(TaskTag $taskTag)
    {
        abort_unless(\Gate::allows('task_tag_delete'), 403);

        $taskTag->delete();

        //$taskTag = taskTag::all();

        //$taskStatus->load('user');
        // return back();
        return redirect()->route('admin.task-tags.index')->with('success',  trans('msg.task_tag_delete.success') );
    }


}
