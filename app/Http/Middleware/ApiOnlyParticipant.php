<?php

namespace App\Http\Middleware;

use Closure;

class ApiOnlyParticipant
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
        if(! \Auth::user()->roles()->get()->contains(3) )
            return apiError('UnAuthorized Access!', 403);

        return $next($request);
    }
}
