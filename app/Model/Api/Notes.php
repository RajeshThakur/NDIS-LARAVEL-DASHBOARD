<?php

namespace App\Model\Api;

use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Notes extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'title',
      'description',
      'user_id',
      'provider_id',
      'relation_id',
      'created_by',
      'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id', 'provider_id'
    ];


    /**
     * Relationship to user table
     */
    public function user()
    {
      return $this->belongsTo(App\User::class);
    }
    
    public static function getParticipantNotes( $participantId ){

        $provider = \Auth::user();
        return Notes::where('users_to_providers.provider_id', $provider->id)->where('notes.user_id', $participantId)
                    ->leftJoin('participants_details', 'notes.user_id_', '=', 'participants_details.user_id')
                    ->leftJoin('users', 'participants_details.user_id', '=', 'users.id')
                    ->leftJoin('users_to_providers', 'participants_details.user_id', '=', 'users_to_providers.user_id')
                    ->select('notes.id','notes.title','notes.description','notes.created_by','notes.created_at')
                    ->get();
  
    }

    public static function getUserNotes( $user_id ){

        $provider = \Auth::user();
        return Notes::where('notes.provider_id', $provider->id)
                    ->whereIn('notes.type', ['participant','support_worker'])
                    ->where('notes.relation_id', $user_id)
                    ->leftJoin('users', 'notes.relation_id', '=', 'users.id')
                    ->select('notes.id','notes.title','notes.description','notes.created_by','notes.created_at')
                    ->get();
  
    }


}
