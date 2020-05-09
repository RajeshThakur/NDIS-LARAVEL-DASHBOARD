<?php
namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ServiceProviderScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if(\Auth::user()){
            $provider = \Auth::user();
            if( !$builder->getQuery()->columns && empty($builder->getQuery()->columns) ){
                $builder->select('service_provider_details.*', 'users.*');
            }
            $builder->leftJoin('users_to_providers', 'service_provider_details.user_id', '=', 'users_to_providers.user_id');
            $builder->leftJoin('users', 'users_to_providers.user_id', '=', 'users.id');

            if( \Auth::user()->roles()->get()->contains( config('ndis.provider_role_id') ) )
                $builder->where('users_to_providers.provider_id', '=', $provider->id);
        }
    }
}