<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


use Illuminate\Support\Facades\DB;

class OperationalForms extends Model
{

    use SoftDeletes;
    
    public $table = 'opforms';
    
    protected $fillable = [
        'title',
        'date',
        'user_id',
        'provider_id',
        'template_id',
    ];


    /**
     * Get the participants
     */
    public function meta()
    {
        return $this->hasMany('App\OpformMeta', 'opform_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Set Attributes
     */
    public function getDateAttribute($value)
    {
        return DBToDate($value);
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = dateToDB($value);
    }

    // public function scopeOpMeta($query)
    // {
    //     return $query->join('opforms_meta as metas', 'opforms.id', '=', 'metas.opform_id');
    //     //dd($query->toSql());
        
    // }

    /**
     * Scope a query to only include users opforms.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeProvider($query, $search="")
    {
        $provider = \Auth::user();

        return $query->leftJoin('users', 'users.id', '=', 'opforms.user_id')
                ->leftJoin('role_user', 'role_user.user_id', '=', 'opforms.user_id')
                ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
                ->whereRaw( '(`users`.`first_name` like "%'.$search.'%" or `users`.`last_name` like "%'.$search.'%" or `opforms`.`title` like "%'.$search.'%")' )
                ->where('opforms.provider_id', $provider->id)
                ->select('opforms.id', 'opforms.title as optitle' ,'opforms.date', 'users.first_name', 'users.last_name', 'roles.title as role');

    }



    /**
     * Scope a query to only include users opforms.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeParticipant($query, $participantId=0)
    {
        $provider = \Auth::user();

        return $query->leftJoin('users', 'users.id', '=', 'opforms.user_id')
                ->leftJoin('role_user', 'role_user.user_id', '=', 'opforms.user_id')
                ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('opforms.provider_id', $provider->id)
                ->where('opforms.user_id', $participantId)
                ->select('opforms.id', 'opforms.title as optitle' ,'opforms.date', 'users.first_name', 'users.last_name', 'roles.title as role','opforms.template_id');

    }


    /**
     * Scope a query to only include users opforms.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSupportWorker($query, $swid=0)
    {
        $provider = \Auth::user();

        return $query->leftJoin('users', 'users.id', '=', 'opforms.user_id')
                ->leftJoin('role_user', 'role_user.user_id', '=', 'opforms.user_id')
                ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('opforms.provider_id', $provider->id)
                ->where('opforms.user_id', $swid)
                ->select('opforms.id', 'opforms.title as optitle' ,'opforms.date', 'users.first_name', 'users.last_name', 'roles.title as role');

    }

    /**
     * Scope a query to only include users opforms.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeServiceProvider($query, $serviceProviderId=0)
    {
        $provider = \Auth::user();

        return $query->leftJoin('users', 'users.id', '=', 'opforms.user_id')
                ->leftJoin('role_user', 'role_user.user_id', '=', 'opforms.user_id')
                ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('opforms.provider_id', $provider->id)
                ->where('opforms.user_id', $serviceProviderId)
                ->select('opforms.id', 'opforms.title as optitle' ,'opforms.date', 'users.first_name', 'users.last_name', 'roles.title as role');

    }


    /**
     * Function that will loop through meta Data for operational forms and will gereneate the associative array and return
     */
    public function getMeta() {
        if($this->id){
            $metaValues = [];
            
            foreach($this->meta as $meta)
                if(is_serialized($meta->meta_value))
                    $metaValues[$meta->meta_key] = unserialize($meta->meta_value);
                else
                    $metaValues[$meta->meta_key] = $meta->meta_value;
            return $metaValues;
        }
    }

    /**
     * Function that will loop through meta Data for operational forms and will gereneate the associative array and return
     */
    public function getMetaRelation() {
        if($this->id){
            
            foreach($this->meta as $meta)
                if(is_serialized($meta->meta_value))
                    $meta[$meta->meta_key] = unserialize($meta->meta_value);
                else
                    $meta[$meta->meta_key] = $meta->meta_value;
        }
    }

    public static function providerOperationalForms( $q = "" )
    {
        $provider = \Auth::user();

        if($q != "") {

            $opforms = DB::table('opforms')
                            ->leftJoin('users', 'users.id', '=', 'opforms.user_id')
                            ->leftJoin('role_user', 'role_user.user_id', '=', 'opforms.user_id')
                            ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
                            ->whereRaw( '(`users`.`first_name` like "%'.$q.'%" or `users`.`last_name` like "%'.$q.'%" or `opforms`.`title` like "%'.$q.'%")' )
                            ->where('opforms.provider_id', $provider->id)
                            ->select('opforms.id', 'opforms.title as optitle' ,'opforms.date', 'users.first_name', 'users.last_name', 'roles.title as role')
                            ->get();

            return $opforms;

        } else {

            $opforms = DB::table('opforms')
            ->leftJoin('users', 'users.id', '=', 'opforms.user_id')
            ->leftJoin('role_user', 'role_user.user_id', '=', 'opforms.user_id')
            ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('opforms.id', 'opforms.title as optitle' ,'opforms.date', 'users.first_name', 'users.last_name', 'roles.title as role')
            ->where('opforms.provider_id', $provider->id)
            ->get();

            return $opforms;
        }
        
    }

}
