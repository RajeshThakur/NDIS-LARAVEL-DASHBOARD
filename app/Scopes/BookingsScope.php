<?php
namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BookingsScope implements Scope
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

        if( \Auth::check() ){
            $provider = \Auth::user();
            
            if( !$builder->getQuery()->columns && empty($builder->getQuery()->columns) ){
                $builder->select(
                    'bookings.*',
                    'booking_orders.id as order_id',
                    'booking_orders.starts_at',
                    'booking_orders.ends_at',
                    'booking_orders.is_billable',
                    'booking_orders.is_cancelled',
                    'booking_orders.cancelled_at',
                    // 'booking_orders.amount',
                    'booking_orders.booking_type',
                    'booking_orders.status',
                    'booking_orders.created_at',
                    'booking_orders.updated_at',
                    'booking_orders.deleted_at'
                    );
            }

            $builder->leftJoin('booking_orders','bookings.id','=','booking_orders.booking_id');

            if( \Auth::user()->roles()->get()->contains( config('ndis.provider_role_id') ) )
                $builder->where('bookings.provider_id', '=', $provider->id);

        }
    }
}