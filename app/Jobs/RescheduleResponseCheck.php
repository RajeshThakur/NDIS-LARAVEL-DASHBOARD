<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\BookingOrders;
use App\BookingOrderMeta;

use App\Notifications\RescheduleBookingApproved;
use App\Notifications\RescheduleBookingDeclined;
use App\Notifications\RescheduleResponsePending;

class RescheduleResponseCheck implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $booking_id = null;
    private $bookingOrder = null;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $bookingOrder)
    {
        // $this->booking_id = $booking_id;
        $this->bookingOrder = $bookingOrder;
    }

     /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $orderMeta = BookingOrderMeta::getMetaVal( $this->bookingOrder->id, config('ndis.booking.reschedule.identifier') );
            
            //Check is reponse has been received? If not notify the Provider
            if( ! $orderMeta['approved'] ){

                //automatically deny after defined period
                $orderMeta['approved'] = 0;
                BookingOrderMeta::saveMeta( $this->bookingOrder->id, config('ndis.booking.reschedule.identifier'), $orderMeta);

                $booking_member = \App\User::findOrFail( $orderMeta['initiated_by_id'] );
                $booking_member->notify(new RescheduleBookingDeclined( $this->bookingOrder ) );
                
            }

        }
        catch(\Exception $e){
            \Log::critical( [ 'Message' => $e->getMessage(), 'file' => $e->getFile(), 'line'=>$e->getLine() ] );
        }
        
    }
}
