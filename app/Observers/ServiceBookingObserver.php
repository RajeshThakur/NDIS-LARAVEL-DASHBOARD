<?php

namespace App\Observers;

use Carbon\Carbon;

use Illuminate\Validation\ValidationException;
use App\Http\Requests\StoreBookingRequest;

use App\Bookings;
use App\Participant;
use App\SupportWorker;
use App\ServiceProvider;


class ServiceBookingObserver
{
    

    public function creating(Bookings $booking)
    {

        // pr($booking, 1);
        // $starts_at = Carbon::parse( $booking->starts_at );
        // $ends_at = Carbon::parse( $booking->ends_at );

        // $participant = \App\Participant::with('availability')
        //                                 ->where('participants_details.user_id',$booking->participant_id)
        //                                 ->where('participants_details.is_onboarding_complete',1)
        //                                 ->first();
        
        // // Check if Participant's NDIS plan is valid
        // if( $starts_at->format( config('panel.date_format') ) <= $participant->start_date_ndis ){
        //     throw ValidationException::withMessages([ 'message'=>"Participant's NDIS plan starts on ".$participant->start_date_ndis ]);
        // }
        
        // if( $ends_at->format( config('panel.date_format') ) >= $participant->end_date_ndis ){
        //     throw ValidationException::withMessages([ 'message'=>"Participant's NDIS plan expired on ".$participant->end_date_ndis ]);
        // }


        // //------------------------------------------------------------
        // // Check for Participant's Availability

        //     // check if Participant is available in the given time frame
        //     $range = strtolower($starts_at->format('l'));

        //     $range_data = $participant->getAvailabilityForRange($range);
        //     if(!$range_data){
        //         throw ValidationException::withMessages([ 'message' => "Participant have't updated his availabilities yet!" ]);
        //     }
            
        //     $range_start = Carbon::parse( $starts_at->format( config('panel.date_format') ) . ' '. $range_data->from );
        //     $range_end = Carbon::parse( $ends_at->format( config('panel.date_format') ) . ' '. $range_data->to );

        //     if( $starts_at->lessThan($range_start) || $ends_at->greaterThan($range_end) ){
        //         throw ValidationException::withMessages([ 'message' => "Participant only available between ".$range_data->from." to ".$range_data->to." on the given day!" ]);
        //     }

        //     //also check if Participant has any other booking on the given date time?

        //         // $booking->where('participant_id',$participant_id)->where('provider_id',$provider->id)->where('starts_at','<=',$dt)
        //         // ->where('period_ends_at','>=',$dt)
        //         //     ->first();
            
            
        // // End of Check for Participant's Availability
        // //------------------------------------------------------------
            
            

        // //------------------------------------------------------------
        // // Check for Support Worker's Availability

        //     if($booking->service_type == 'support_worker'){
        //         $booking = $booking->where('supp_wrkr_ext_serv_id',$booking->supp_wrkr_ext_serv_id)
        //                     ->where('provider_id',$booking->provider_id)
        //                     ->whereRaw(
        //                         '(
        //                             ( `starts_at` <= "'.$booking->starts_at.'" AND `ends_at` >= "'.$booking->starts_at.'" ) OR
        //                             ( `starts_at` <= "'.$booking->ends_at.'" AND `ends_at` >= "'.$booking->ends_at.'" ) 
        //                         )'
        //                     )
        //                     ->first();
        //         // pr($booking, 1);
        //         if($booking){
        //             throw ValidationException::withMessages([ 'message' => "Support Worker is already booked on given date/time!" ]);
        //         }
        //     }

        // // End of Check for Support Worker's Availability
        // //------------------------------------------------------------
        
    }

    /**
     * Handle the service booking "created" event.
     *
     * @param  \App\Bookings  $booking
     * @return void
     */
    public function created(Bookings $booking)
    {
        
    }

    /**
     * Handle the service booking "updated" event.
     *
     * @param  \App\Bookings  $booking
     * @return void
     */
    public function updated(Bookings $booking)
    {
        //
    }

    /**
     * Handle the service booking "deleted" event.
     *
     * @param  \App\Bookings  $booking
     * @return void
     */
    public function deleted(Bookings $booking)
    {
        //
    }

    /**
     * Handle the service booking "restored" event.
     *
     * @param  \App\Bookings  $booking
     * @return void
     */
    public function restored(Bookings $booking)
    {
        //
    }

    /**
     * Handle the service booking "force deleted" event.
     *
     * @param  \App\Bookings  $booking
     * @return void
     */
    public function forceDeleted(Bookings $booking)
    {
        //
    }

}
