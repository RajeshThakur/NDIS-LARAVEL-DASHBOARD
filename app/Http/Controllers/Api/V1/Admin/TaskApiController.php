<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Task;

class TaskApiController extends Controller
{
    public function index()
    {
        // abort_unless(\Gate::allows('task_access'), 403);
        
        $tasks = Task::withoutGlobalScope('provider')->get();

        // pr($tasks,1);

        return $tasks;
    }

    public function store(StoreTaskRequest $request)
    {
        return Task::create($request->all());
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        return $task->update($request->all());
    }

    public function show(Task $task)
    {
        return $task;
    }

    public function destroy(Task $task)
    {
        return $task->delete();
    }
}
