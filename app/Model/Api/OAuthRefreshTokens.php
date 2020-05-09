<?php

namespace App\Model\Api;

use Illuminate\Database\Eloquent\Model;

class OAuthRefreshTokens extends Model
{
    
    public $table = 'oauth_refresh_tokens';

    public $timestamps = false;

    protected $fillable = [
        'access_token_id',
        'revoked',
        'expires_at'
    ];


}
