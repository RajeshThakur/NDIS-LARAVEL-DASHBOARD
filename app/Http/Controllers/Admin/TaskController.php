<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Controllers\Traits\Common;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Task;
use App\TaskStatus;
use App\TaskTag;
use App\User;

use DB;

use App\Events\TaskCreated;
use Symfony\Component\HttpFoundation\Request;

use Illuminate\Notifications\Notifiable;
use App\Notifications\EventCreated;
use App\Notifications\EventUpdated;




class TaskController extends Controller
{
    use MediaUploadingTrait, Common, Notifiable;

    public function index(Request $request)
    {
        abort_unless(\Gate::allows('task_access'), 403);

        $searchString = null;

        if( isset( $request->s ) ){
            $searchString = $request->s;
            $tasks = Task::with('assignees')->searchTasks()->get();
            $size = sizeof($tasks);
            $result = 'result';
            if( $size > 1) $result = 'results';
            $msg = "Found <strong>'" .$size ."'</strong> ". $result." for your query of <strong>'" .$request->s ."'</strong>";
            $tasks->search = array( 'message'=>$msg);
        }
        else{
            $tasks = Task::with('assignees')->get();
        }

        return view('admin.events.index', compact('tasks','searchString'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('task_create'), 403);        

        $statuses = TaskStatus::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $_colors = \App\Colors::all();
        $colors = [];
        foreach($_colors as $_color)
            $colors[$_color->id] = '<span class="'.$_color->color.'-bg color-patch"></span> '.$_color->name;

        $tag = TaskTag::first();
        
        // $assigned_tos = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $assignables = Task::getAssignableUsers();
       
        return view('admin.events.create', compact('statuses', 'colors', 'assignables', 'tag'));
    }

    public function store(StoreTaskRequest $request)
    {
        abort_unless(\Gate::allows('task_create'), 403);

        $provider = \Auth::user();

        $task_assignees = $request->input('task_assignee_id');

        $task_assignees[] = $provider->id;
        // pr($request->all(),1);
        $task = $this->addTask(
                        [
                            'name' =>$request->name,
                            'due_date' =>$request->due_date,
                            'start_time' => $request->start_time ,
                            'end_time' => $request->start_time ,
                            'location' => $request->location,
                            'lng' => $request->lng,
                            'lat' => $request->lat,
                            'description' => $request->description,
                            'status_id' => $request->status_id,
                            'provider_id' => $provider->id,
                            'created_by_id' => $provider->id,
                            'color_id' => $request->color_id,
                        ],
                        $request->input('tags', [1]),
                        $task_assignees
        );

        $task->load('assignees');

        //Send Notification to each Assignee
        foreach($task->assignees as $assignee)
            $assignee->notify( new EventCreated($task->toArray() ) );

        return redirect()->route('admin.events.index')->with('success', trans('msg.task_add.success'));;
    }

    public function edit(Task $task, $taskId)
    {
        abort_unless(\Gate::allows('task_edit'), 403);

        $task = $task->find($taskId);
        abort_unless($task, 404);

        if( $task->status_id == 4 )
            return  redirect()->route('admin.events.show',$taskId);

        $statuses = TaskStatus::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        
        $_colors = \App\Colors::all();
        $colors = [];
        foreach($_colors as $_color)
            $colors[$_color->id] = '<span class="'.$_color->color.'-bg color-patch"></span> '.$_color->name;

        $task->load('status', 'tags', 'assignees');

        $assignables = Task::getAssignableUsers();

        $assignees = $task->assignees->pluck('id')->toArray();
        $assignedTags = $task->tags->pluck('id')->toArray();

        return view('admin.events.edit', compact('statuses', 'colors', 'assignedTags', 'task', 'assignables', 'assignees'));
    }

    public function update(UpdateTaskRequest $request, Task $task, $taskId)
    {
        abort_unless(\Gate::allows('task_edit'), 403);

        $task = $task->find($taskId);

        $provider = \Auth::user();
        
        $task_assignees = $request->input('task_assignee_id');
        $task_assignees[] = $provider->id;

        $task->update([
                                'name' =>$request->name,
                                'due_date' =>$request->due_date,
                                'start_time' => date( "H:i:s", strtotime( $request->start_time ) ),
                                'end_time' => date( "H:i:s", strtotime( $request->end_time) ),
                                'location' => $request->location,
                                'lng' => $request->lng,
                                'lat' => $request->lat,
                                'color_id' => $request->color_id,
                                'description' => $request->description,
                                'status_id' => $request->status_id,
                                'provider_id' => $provider->id,
                                'created_by_id' => $provider->id,
                        ]);

        $task->tags()->sync($request->input('tags', []));
        $task->assigned_to_update()->sync($task_assignees);
        
        $task->load('assignees');
        // pr($task->assignees->, 1);
        foreach( $task->assignees as $k=>$assignee){
            $assignee->notify( new EventUpdated( $task->toArray() ) );
        }



        $provider->notify( new EventUpdated( $task->toArray() ) );

        return redirect()->route('admin.events.index')->with('success', trans('msg.task_update.success') );
    }

    public function show(Task $task, $taskId)
    {
        abort_unless(\Gate::allows('task_show'), 403);

        $task = Task::findOrfail($taskId);

        $task->load('status', 'tags', 'assigned_to');
        // dd($task);
        return view('admin.events.show', compact('task'));
    }

    public function destroy(Task $task)
    {
        abort_unless(\Gate::allows('task_delete'), 403);

        $task->delete();

        // return back();
        return redirect()->route('admin.events.index')->with('success', trans('msg.task_delete.success') );
    }


}
