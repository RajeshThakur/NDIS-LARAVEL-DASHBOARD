<?php

namespace App\Http\Middleware;

use Closure;

class ApiOnlySupportWorker
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

        if(! \Auth::user()->roles()->get()->contains( config('ndis.support_worker_role_id') ) )
            return apiError('UnAuthorized Access!', 403);
            
        return $next($request);
    }
}
