<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Notifications\ServiceBookingDue;


class BookingIsDue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Booking:IsDue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to Participant and Worker for each booking before a day, an hour and on booking start time';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Log::info("Running Cron Booking:IsDue!");
        // Database Operations here

        $dayBefore = Carbon::now()->addDay()->toDateString();
        $hourBefore = Carbon::now()->addHour()->toDateString();
        $inSecs = Carbon::now();

        //bookings due in a day
        $day =\App\BookingOrders::whereStatus( config('ndis.booking.statuses.Scheduled') )
                                ->whereDate( 'booking_orders.starts_at', $dayBefore )
                                ->get();        
        if( $day->isNotEmpty() ):
            foreach($day as $dueBooking){
                $participant = \App\User::find( $dueBooking->booking->participant_id );
                $worker = \App\User::find( $dueBooking->booking->supp_wrkr_ext_serv_id );
                $participant->notify( new ServiceBookingDue(  $dueBooking, 'day','participant' ) );
                $worker->notify( new ServiceBookingDue(  $dueBooking, 'day','worker' ) );
            }
        endif;

        //bookings due in an hour
        $hour =\App\BookingOrders::whereStatus( config('ndis.booking.statuses.Scheduled') )
                                ->whereDate( 'booking_orders.starts_at', $hourBefore )
                                ->get();        
        if( $hour->isNotEmpty() ):
            foreach($hour as $dueBooking){
                $participant = \App\User::find( $dueBooking->booking->participant_id );
                $worker = \App\User::find( $dueBooking->booking->supp_wrkr_ext_serv_id );
                $participant->notify( new ServiceBookingDue(  $dueBooking, 'hour','participant' ) );
                $worker->notify( new ServiceBookingDue(  $dueBooking, 'hour','worker' ) );
            }
        endif;

        //bookings just began
        $now =\App\BookingOrders::whereStatus( config('ndis.booking.statuses.Scheduled') )
                                ->whereDate( 'booking_orders.starts_at', $inSecs )
                                ->get();        
        if( $now->isNotEmpty() ):
            foreach($now as $dueBooking){
                $participant = \App\User::find( $dueBooking->booking->participant_id );
                $worker = \App\User::find( $dueBooking->booking->supp_wrkr_ext_serv_id );
                $participant->notify( new ServiceBookingDue(  $dueBooking, 'now','participant' ) );
                $worker->notify( new ServiceBookingDue(  $dueBooking, 'now','worker' ) );
            }
        endif;       

        $this->info('Booking:IsDue Command Run successfully!');
    }
}
