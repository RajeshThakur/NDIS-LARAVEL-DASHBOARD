<?php

namespace App\Model\Api;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Database\Eloquent\Builder;

use App\UsersToProviders;
use DB;

class Task extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    public $table = 'tasks';

    protected $dates = [
        'due_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'due_date',
        'status_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'description',
        'provider_id',
        'created_by_id',
        'location',
        'lng',
        'lat',
        'color_id',
        'start_time',
        'end_time',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('provider', function (Builder $builder) {
            $provider = \Auth::user();
            $builder->where('tasks.provider_id', '=', $provider->id);
        });
    }

    public function status()
    {
        return $this->belongsTo(TaskStatus::class, 'status_id');
    }

    public function tags()
    {
        return $this->belongsToMany(TaskTag::class);
    }

    public function assignees()
    {
        // return $this->hasMany(\App\TaskAssignee::class, 'task_id');
        return $this->hasManyThrough(
                                        \App\User::class,
                                        \App\TaskAssignee::class,
                                        'task_id', // Foreign key on TaskAssignee to Current Model Table
                                        'id',   // Foreign key on User table...
                                        'id',   // Local key on Task table...
                                        'task_assignee_id'   // Local key on TaskAssignee table and Foreign Key to Users Table
                                    );
    }
    
    public function getattachmentAttribute()
    {
        return $this->getMedia('attachment')->last();
    }


    public function getDueDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDueDateAttribute($value)
    {
        $this->attributes['due_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function assigned_to()
    {
        // return $this->belongsTo(User::class);
        return $this->belongsToMany(TaskAssignee::class);
    }


    public static function getAssignableUsers(){

        $isProvider = false;
        $user = \Auth::user();
        foreach($user->roles as $role){
            if($role->id == config('provider_role_id'))
                $isProvider = true;
        }

        if( $isProvider )
            $assignables = UsersToProviders::with('user')->where('provider_id',$user->id )->get();
        else
            $assignables = UsersToProviders::with('user')->get();

        // pr($assignables, 1);
        
        if( sizeof( $assignables ) ){
            foreach ( $assignables as $usr){
                $currentUser = User::find($usr->user_id);
                if( !empty($currentUser))
                    $u[ $usr->user_id ] = $currentUser['first_name'] . ' ' . $currentUser['last_name'] . ' ( ' . $currentUser['email'] . ' )';
            }
        }
        else{
            $u = [];
        }

        // die();
        return $u;
    }

    public static function scopeSearchTasks($query)
    {
        $term = trim(\Request::get('s'));
        return $query->where('name', 'LIKE' , "%".$term."%")->orWhere('description', 'LIKE' , "%".$term."%");
    }


    public static function getAssignees($task)
    {

        $user = \Auth::user();
        
        return \DB::table('task_task_assignee')
                   ->where('task_id',$task->id)
                   ->leftJoin('users', 'users.id', '=', 'task_task_assignee.user_id')
                //    ->select('task_task_assignee.user_id','users.first_name','users.last_name','users.email' )
                   ->select('task_task_assignee.user_id')
                   ->get();
    }


    /**
     * Scope a query to include assignees from table task_task_assignee 
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    // public function scopeAssignees($query)
    // {
    //     // pr($query,1);
    //     $user = \Auth::user();
    //     return $query
    //             ->where('provider_id',$user->id)
    //             ->leftJoin('task_task_assignee', 'tasks.id_', '=', 'task_task_assignee.task_id')
    //             ->distinct()
    //             ->select('tasks.*', 'task_task_assignee.user_id' );
    //             // ->groupBy('tasks.id')
    //             // ->get();
    // }

    /**
     * Scope a query to fetch only ovedue tasks of current provider user
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOverdues($query)
    {
        $user = \Auth::user();
        return $query
                ->where([
                            // ['provider_id','=',$user->id],
                            ['status_id','!=',3],
                            ['due_date','<', \Carbon\Carbon::now()->toDateString()],
                        ]);
                // ->leftJoin( 'task_task_assignee', 'tasks.id', '=', 'task_task_assignee.task_id' )
                // ->leftJoin( 'users', 'users.id', '=', 'task_task_assignee.user_id' )
                // ->select( 'tasks.*', 'task_task_assignee.user_id','users.first_name','users.last_name' );
                // ->toSql();
    }

    /**
     * Scope a query to fetch only upcoming tasks for participants 
     * under current provider user
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpcomingParticipantBookings($query){

        $user = \Auth::user();
        
        return $query;
    }


}
