<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TaskAssignee extends Model
{
    public $table = 'task_task_assignee';

    public $timestamps = false;
    
    protected $fillable = [
        'task_id',
        'task_assignee_id',
    ];
}
