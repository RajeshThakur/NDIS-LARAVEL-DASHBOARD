<?php

namespace App;

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

use Laravel\Cashier\Billable;



class User extends Authenticatable
{
    use SoftDeletes, Notifiable, Messagable, HasApiTokens, Billable;

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

    //-----------------------------------------------------------------------------------
    // Relationship

    /**
     * participants relationship
     */
    public function participant()
    {
        // return $this->belongsTo('App\Participant', 'id');
        return $this->hasOne('App\Participant', 'user_id', 'id');
    }

    /**
     * participants relationship
     */
    public function supportWorker()
    {
        return $this->hasOne('App\SupportWorker', 'user_id');
    }

    /**
     * participants relationship
     */
    public function provider()
    {
        return $this->hasOne('App\Provider', 'user_id', 'id');
    }

    /**
     * participants relationship
     */
    public function serviceProvider()
    {
        return $this->hasOne('App\ServiceProvider', 'user_id');
    }

    /**
     * 
     */
    public function UserProvider()
    {
        return $this->hasMany('App\UsersToProviders');
    }
    
    /**
     * Relationship with Roles
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Relationship with Signatures
     */
    public function signature()
    {
        return $this->hasOne(\App\Signature::class, 'user_id', 'id');
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

    /**
     * relationship to Documents one User can have many documents
     */
    public function documents()
    {
      return $this->hasMany(App\documents::class);
    }

    public function profile()
    {
        return $this->hasOne('App\Provider');
    }

    /**
     * Relationship with Signatures
     */
    public function incidents()
    {
        return $this->hasMany(\App\BookingIncidents::class, 'created_by');
    }

    /**
     * Relationship with Signatures
     */
    public function complaints()
    {
        return $this->hasMany(\App\BookingComplaints::class, 'created_by');
    }

    //------------------------------------------------------------------------------------
    // Field Attributes
    
    public function getEmailVerifiedAtAttribute($value)
    {
        return DBToDatetime($value);
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = datetimeToDB($value);
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    //------------------------------------------------------------------------------------
    // Functions

    public function getName(){
        if(isset($this->first_name))
            return $this->first_name . ' ' . $this->last_name;
        else
            return '';
    }

    public function getRoles(){
        $return = [];
        foreach( $this->roles()->get() as $role ){
            $return[$role->id] = $role->title;
        }
        return $return;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
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


    //--------------------------------------------------------------------------------------------------
    // Local scope Methods
    //--------------------------------------------------------------------------------------------------


    public function scopeProviderUsers(){
        return $this->leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
                    ->where( 'role_user.role_id', '2' )
                    ->get();
    }

}
