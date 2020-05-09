<?php

namespace App\Http\Middleware;

use Closure;

class ApiAuthCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if( !\Auth::check() )
            return apiError('UnAuthorized Access!', 400);

        if(! \Auth::user()->roles()->whereIn('id', [3,4])->first() )
            return apiError('UnAuthorized Access!', 403);

        return $next($request);
    }
}
