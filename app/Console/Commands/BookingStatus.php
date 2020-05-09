<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Bookings;
use App\BookingOrders;


class BookingStatus extends Command
{

    protected $log_id;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Booking:Status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command will check the booking status and complete the service bookings based on end time or will create task for provider and update status accordingly';

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
     * Create log for the Cron job in the database
     *
     * @return void
     */
    private function logCron(){
        
        if($this->log_id){
            
        }else{
            $cron = \App\CronLogs::create([
                                            'command_name' => 'Booking:Status',
                                            'data' => json_encode($data),
                                            'started_at' => 'Booking:Status',
                                        ]);
            if($cron){
                $this->log_id=$cron->id;
            }
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Log::info("Running Cron Booking:Status!");
        // Database Operations here

        $dateTimePrior = Carbon::now()->subMinutes( config('ndis.booking.process_wait_time') )->format( config('panel.db_datetime_format') );

        \Log::info("Looking for bookings prior to:".$dateTimePrior);
        

        // $unAttendedBookings = BookingOrders::with('booking')
        $unAttendedBookings = BookingOrders::whereIn('booking_orders.status', [ config('ndis.booking.statuses.Scheduled'), config('ndis.booking.statuses.Started') ] )
                                ->whereDate('booking_orders.ends_at', '<=', $dateTimePrior )
                                ->get();

        foreach($unAttendedBookings as $_bookingOrder){
            \App\Jobs\BookingCompletionJob::dispatch($_bookingOrder->id);
            \Log::info("Queued Booking Order Id:".$_bookingOrder->id);
        }
        
        $this->info('Booking:Status Command Run successfully!');
    }
}
