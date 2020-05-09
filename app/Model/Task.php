<?php

namespace App;

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
    
    public function assigned_to()
    {
        // return $this->belongsTo(User::class);
        return $this->belongsTo(TaskAssignee::class);
    }

    public function assigned_to_update()
    {
        // return $this->belongsTo(User::class);
        return $this->belongsToMany(TaskAssignee::class);
    }
    


    /**
     * Set Attributes
     */
    public function getattachmentAttribute()
    {
        return $this->getMedia('attachment')->last();
    }
    
    public function getDueDateAttribute($value)
    {
        return dbToDate($value);
    }

    public function setDueDateAttribute($value)
    {
        $this->attributes['due_date'] = dateToDB($value);
    }

    public static function scopeTagId($query)
    {
        $term = trim(\Request::get('s'));
        return $query->where('name', 'LIKE' , "%".$term."%")->orWhere('description', 'LIKE' , "%".$term."%");
    }

    public static function scopeNormal($query)
    {
        // return $query->select('tasks.*')->whereIn( 'id', function ($query) {
        //                                                     $query->distinct()
        //                                                     ->select('participant_id')
        //                                                     ->from(with(new Bookings)->getTable())
        //                                                     ->where('supp_wrkr_ext_serv_id', $supp_wrkr_ext_serv_id);
        //                                 })->get();
        return $query->select('tasks.*')
                    ->leftJoin('task_task_tag','tasks.id','=','task_task_tag.task_id')
                    ->leftJoin('task_tags','task_tags.id','=','task_task_tag.task_tag_id')
                    ->whereNotIn('task_tags.id', [2,3,4] );
    }

    public static function scopeSearchTasks($query)
    {
        $term = trim(\Request::get('s'));
        return $query->where('name', 'LIKE' , "%".$term."%")->orWhere('description', 'LIKE' , "%".$term."%");
    }

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
                // ->where('due_date','<', \Carbon\Carbon::now()->toDateString())
                ->whereNotIn( 'status_id',['4']);
    }

    /**
     * Scope a query to fetch only upcoming tasks for participants 
     * under current provider user
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpcomingParticipantBookings($query)
    {

        $user = \Auth::user();
        
        return $query;
    }


    


    public static function getAssignableUsers()
    {

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

        //Add self to assignable list
        $u[$user->id] = $user->first_name . ' ' . $user->last_name . ' ( ' . $user->email . ' )';

        return $u;
    }


    public static function getAssignees($task)
    {

        $user = \Auth::user();
        
        return \DB::table('task_task_assignee')
                   ->where('task_id',$task->id)
                   ->leftJoin('users', 'users.id', '=', 'task_task_assignee.user_id')
                   ->select('task_task_assignee.user_id')
                   ->get();
    }



    

}
