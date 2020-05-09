<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TaskNotifier extends Command
{

    protected $log_id;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Task:Notifier';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command will check the booking status and complete the service bookings based on end time or will create task for them for provider and update status accordingly';

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
                                        'command_name' => 'Task:Notifier',
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
        \Log::info("Running Cron Task:Notifier!");
        
        // Database Operations here
        

        
        
        $this->info('Task:Notifier Command Run successfully!');
    }
}
