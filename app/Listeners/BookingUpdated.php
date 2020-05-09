<?php

namespace App\Listeners;

use App\Events\UpdateFunds;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\DB;
use App\BookingOrders;

class BookingUpdated
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
        
        if ($event->data['type'] == 'update'){
            try{

                $booking_order = BookingOrders::find($event->data['order_id']);

                // dd($booking_order);

                $parti = DB::table('participants_details')->where('user_id', $booking_order->booking->participant_id);

                //revert previous booking amount
                $oldBookingAmount  = \App\BookingOrderMeta::getMetaVal($event->data['order_id'],'booking_amount');
                $parti->update(['funds_balance' => ( $parti->pluck('funds_balance')->first() + $oldBookingAmount ) ]);


                // Deduct booking amount from participants funds balance                
                $reg_item = \App\RegistrationGroup::withoutGlobalScopes()->whereId($booking_order->booking->item_number)->first();
                //fetch item amount from provider reg groups table
                $provider_reg_item = \App\ProviderRegGroups::withoutGlobalScopes()->whereRegGroupId($booking_order->booking->item_number)->first();
                $providerRate = $provider_reg_item->cost;
                $total_time = round( \Carbon\Carbon::parse($booking_order->ends_at)->floatDiffInHours(\Carbon\Carbon::parse($booking_order->starts_at)),2);
                if( $reg_item->unit == "H" ):
                    $total_amount = $providerRate * $total_time; //provider rate * booking hrs
                else: 
                    $total_amount = $providerRate; //provider rate
                endif;                
                // $parti = DB::table('participants_details')->where('user_id', $booking_order->booking->participant_id);
                $participant = new \App\Participant;
                $parti = $participant->getParticipant($booking_order->booking->participant_id);

                $participant_total_fund = $parti->funds_balance;
                $participant_balance_fund = $participant_total_fund - $total_amount;

                $parti->update(['funds_balance' => $participant_balance_fund]);

                \App\BookingOrderMeta::saveMeta( $event->data['order_id'], 'booking_amount', $total_amount);

            }
            catch(Exception $e){
                return response()->json([ 'status'=>false, 'message'=>$e->getMessage() ]);
            }
        } 
        
    }
}
