<?php

namespace Dmark\Messenger\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

use DB;

class Message extends Eloquent
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'messages';

    /**
     * The relationships that should be touched on save.
     *
     * @var array
     */
    protected $touches = ['thread'];

    /**
     * The attributes that can be set with Mass Assignment.
     *
     * @var array
     */
    protected $fillable = ['thread_id', 'user_id', 'body'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    protected $appends = ['sender'];

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = Models::table('messages');

        parent::__construct($attributes);
    }

    /**
     * Thread relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @codeCoverageIgnore
     */
    public function thread()
    {
        return $this->belongsTo(Models::classname(Thread::class), 'thread_id', 'id');
    }

    /**
     * User relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @codeCoverageIgnore
     */
    public function user()
    {
        return $this->belongsTo(Models::user(), 'user_id');
    }

    /**
     * Participants relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @codeCoverageIgnore
     */
    public function participants()
    {
        return $this->hasMany(Models::classname(Participant::class), 'thread_id', 'thread_id');
    }

    /**
     * Recipients of this message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipients()
    {
        return $this->participants()->where('user_id', '!=', $this->user_id);
    }

    function getSenderAttribute() {
        return $this->user()->first()->getName();
    }

    /**
     * Returns unread messages given the userId.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnreadForUser(Builder $query, $userId)
    {
        return $query->has('thread')
            ->where('user_id', '!=', $userId)
            ->whereHas('participants', function (Builder $query) use ($userId) {
                $query->where('user_id', $userId)
                    ->where(function (Builder $q) {
                        $q->where('last_read', '<', $this->getConnection()->raw($this->getConnection()->getTablePrefix() . $this->getTable() . '.created_at'))
                            ->orWhereNull('last_read');
                    });
            });
    }


    public static function getMessagable( ){ 
        $user =  \Auth::user();
        
        if( \Auth::user()->roles()->get()->contains( config('ndis.provider_role_id') ) ):
            return DB::table('users_to_providers')
                    ->where('users_to_providers.provider_id','=', $user->id)
                    ->leftJoin('users','users.id', '=','users_to_providers.user_id' )
                    ->select('users.first_name','users.last_name', 'users.email', 'users.id')
                    ->get();
        endif;

        if( \Auth::user()->roles()->get()->contains( config('ndis.participant_role_id') ) ):

            $workers = DB::table('bookings')
                        ->where('bookings.participant_id','=',$user->id)
                        ->leftJoin('users','users.id', '=','bookings.supp_wrkr_ext_serv_id')
                        ->leftJoin('role_user','role_user.user_id', '=','bookings.supp_wrkr_ext_serv_id')
                        ->select('users.first_name','users.last_name', 'users.email', 'users.id','role_user.role_id')
                        ->distinct()
                        ->get();

            $providers = DB::table('users_to_providers')
                        ->where('users_to_providers.user_id','=', $user->id)
                        ->leftJoin('users','users.id', '=','users_to_providers.provider_id' )
                        ->leftJoin('role_user','role_user.user_id', '=','users_to_providers.provider_id' )
                        ->select('users.first_name','users.last_name', 'users.email', 'users.id','role_user.role_id')
                        // ->groupBy('users.id')
                        ->distinct()
                        ->get();

            return $workers->mergeRecursive($providers);
        endif;

        if( \Auth::user()->roles()->get()->contains( config('ndis.support_worker_role_id') ) ):
            
            $participants = DB::table('bookings')
                        ->where('bookings.supp_wrkr_ext_serv_id','=',$user->id)
                        ->leftJoin('users','users.id', '=','bookings.participant_id')
                        ->leftJoin('role_user','role_user.user_id', '=','bookings.participant_id')
                        ->select('users.first_name','users.last_name', 'users.email', 'users.id','role_user.role_id')
                        ->distinct()
                        ->get();
            
            $providers = DB::table('users_to_providers')
                        ->where('users_to_providers.user_id','=', $user->id)
                        ->leftJoin('users','users.id', '=','users_to_providers.provider_id' )
                        ->leftJoin('role_user','role_user.user_id', '=','users_to_providers.provider_id' )
                        ->select('users.first_name','users.last_name', 'users.email', 'users.id','role_user.role_id')
                        // ->groupBy('users.id')
                        ->distinct()
                        ->get();
            // dd($providers);
             return $participants->merge($providers);
        endif;


        return DB::table('users')->select('users.first_name','users.last_name', 'users.email', 'users.id')->distinct()->get();

        


        
    }
}
// \Auth::id()