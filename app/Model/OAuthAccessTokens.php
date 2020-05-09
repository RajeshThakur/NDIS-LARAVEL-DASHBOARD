<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OAuthAccessTokens extends Model
{
    public $table = 'oauth_access_tokens';


    protected $fillable = [
        'user_id',
        'client_id',
        'name',
        'scopes',
        'revoked',
    ];

}
