<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->app['validator']->extend('enum', function ($attribute, $value, $parameters)
        {
            if(is_array($parameters)){
                if(!in_array($value, $parameters)){
                    return false;
                }
            }
            return true;
        });

        $this->app['validator']->extend('worker', function ($attribute, $value, $parameters)
        {
            $swuser = \App\User::find($value);
            if( $swuser && array_key_exists( config('ndis.support_worker_role_id'), $swuser->getRoles())  )
                return true;
            else
                return false;
        });

        $this->app['validator']->extend('participant', function ($attribute, $value, $parameters)
        {
            $swuser = \App\User::find($value);
            if( $swuser && array_key_exists( config('ndis.participant_role_id'), $swuser->getRoles())  )
                return true;
            else
                return false;
        });
    }

    public function register()
    {
        //
    }
}