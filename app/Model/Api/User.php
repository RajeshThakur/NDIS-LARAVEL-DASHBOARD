<?php

namespace App\Model\Api;

use App\Notifications\VerifyUserNotification;
use Carbon\Carbon;
use Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

use Dmark\Messenger\Traits\Messagable;

use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use SoftDeletes, Notifiable, Messagable, HasApiTokens;

    const ACTIVE = 1;
    const INACTIVE = 0;

    public $table = 'users';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        'email_verified_at',
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'avatar',
        'mobile',
        'password',
        'created_at',
        'updated_at',
        'deleted_at',
        'remember_token',
        'email_verified_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::created(function (User $user) {

            $registrationRole = config('panel.registration_default_role');
            $this->role = $user->roles();

            // if (!$user->roles()->get()->contains($registrationRole)) {
                // $user->roles()->attach($registrationRole);
            // }
        });
    }


    /**
     * Boot function to perform functions for the Model Events
     */
    public static function boot()
    {
        parent::boot();

        // self::creating(function($model){
        //     $token = Str::random(32);
        //     pr($model, 1);
        // });

        // static::addGlobalScope('age', function (Builder $builder) {
            // If Role == Provider
            // $builder->where('age', '>', 200);
        // });

    }


    /**
     * participants relationship
     */
    public function participant()
    {
        // return $this->belongsTo('App\Participant', 'id');
        return $this->hasOne('App\Participant','user_id');
    }

    /**
     * participants relationship
     */
    public function supportWorker()
    {
        // return $this->belongsTo('App\Participant', 'id');
        return $this->hasOne('App\SupportWorker','user_id');
    }

    /**
     * 
     */
    public function UserProvider()
    {
        return $this->hasMany('App\UsersToProviders','user_id');
    }
    
    /**
     * Relationship with Roles
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

     /**
     * Relationship with Roles
     */
    public function rolesFilter()
    {
        return $this->belongsToMany(Role::class)->wherePivotIn('role_id', [3, 4, 5]);
    }

    
    public function OAuthAcessToken(){
        return $this->hasMany('\App\OAuthAccessTokens');
    }


    public function getRoles(){
        
        $return = [];
        foreach( $this->roles()->get() as $role ){
            $return[$role->id] = $role->title;
        }
        return $return;
    }


    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    

    /**
     * relationship to Documents one User can have many documents
     */
    public function documents()
    {
      return $this->hasMany(App\documents::class);
    }

    public function profile()
    {
            return $this->hasOne('App\Provider','','user_id');

    }





    //--------------------------------------------------------------------------------------------------
    // API Methods
    //--------------------------------------------------------------------------------------------------

    public function getUserProviders(){
        
        return $this->where( 'users.id', $this->id )->whereNull('users_to_providers.deleted_at')
                    ->leftJoin('users_to_providers', 'users.id', '=', 'users_to_providers.user_id')
                    ->leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
                    ->distinct()
                    ->select('users.id', 'role_user.role_id', 'users_to_providers.provider_id')
                    ->get();

        // return Participant::where('users_to_providers.user_id', $this->id)
        
        //                     ->select('users.*')
        //                     ->get();
    }

    

}
