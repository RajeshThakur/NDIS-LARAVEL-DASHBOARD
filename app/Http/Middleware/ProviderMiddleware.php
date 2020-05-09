<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;

class ProviderMiddleware
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
        $admin_role = config('panel.admin_role');
        $provider_role = config('panel.provider_role');
        
        if($request->user()->roles()->get()->contains($admin_role)){
            // $request->request->add([ 'where_user'=>$request->user()->id ]);
        }
        else if($request->user()->roles()->get()->contains($provider_role)){
            $request->request->add([ 'where_user'=>$request->user()->id ]);
        }
        else{
            abort_unless(false, 403);
        }


        $unreadNotificationCount = getTotalMessage();
        // add $notificationCount to your request instance and use in view like {{ request('unreadNotificationCount') }}
        // $request->request->add(['unreadNotificationCount' => $unreadNotificationCount]);
        View::share('unreadNotificationCount', $unreadNotificationCount);

        // $notifications = \Auth::user()->notifications()->limit(5)->get();
        
        return $next($request);
    }
}
