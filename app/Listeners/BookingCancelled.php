<?php

namespace App\Listeners;

use App\Events\UpdateFunds;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Carbon\Carbon;
use App\BookingOrders;
use Illuminate\Support\Facades\DB;

class BookingCancelled
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UpdateFunds  $event
     * @return void
     */
    public function handle(UpdateFunds $event)
    {
        if ($event->data['type'] == 'cancel'){
            try{              

                $booking_order = BookingOrders::find($event->data['order_id']);
                $parti = DB::table('participants_details')->where('user_id', $booking_order->booking->participant_id);
                $now = Carbon::now();
                $starts_at = Carbon::parse($booking_order->starts_at);

                if( $starts_at->diffInMinutes($now) >= 1440 ){ //if more than 24hrs are left before booking commence, refund booking amount

                    $oldBookingAmount  = \App\BookingOrderMeta::getMetaVal($event->data['order_id'],'booking_amount');
                    $parti->update(['funds_balance' => ( $parti->pluck('funds_balance')->first() + $oldBookingAmount ) ]);
                }

            }
            catch(Exception $e){
                return response()->json([ 'status'=>false, 'message'=>$e->getMessage() ]);
            }
        } 
    }
}
