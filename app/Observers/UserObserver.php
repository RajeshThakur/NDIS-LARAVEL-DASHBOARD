<?php

namespace App\Observers;

use Illuminate\Support\Str;

use App\User;


class UserObserver
{

    public function creating(User $user)
    {

        $_user = User::where('email',$user->email)->first();

        if(isset($_user->id)){
            // $user->id = $_user->id;
            return false;
        }

        $user->active = $user->active?$user->active:0;
        $user->token = Str::random(32);
        
    }

    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //Delete relationship Data or not here??
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
