<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\ProviderPlanExpiring;
use Carbon\Carbon;


class ProviderPlanStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ProviderPlan:Status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if NDIS plan of provider is expiring';

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
        \Log::info("Running Cron ProviderPlan:Status!");
        // Database Operations here        

        \Log::info("Looking for providers whose NDIS plan are about to expire");
        
        $weekBefore = Carbon::now()->addWeek()->toDateString();
        $monthBefore = Carbon::now()->addMonth()->toDateString();
        $dayBefore = Carbon::now()->addDay()->toDateString();
        $today = Carbon::now()->toDateString();
        
        $month = \App\Provider::where('renewal_date', $monthBefore )->get();
        if( $month->isNotEmpty() ):
            foreach($month as $renewal){
                $provider = \App\User::find($renewal->user_id);
                $provider->notify( new ProviderPlanExpiring( $renewal, 'month' ) );
            }
        endif;

        $week = \App\Provider::where('renewal_date', $weekBefore )->get(); 
        if( $week->isNotEmpty() ):
        foreach($week as $renewal){
            $provider = \App\User::find($renewal->user_id);
            $provider->notify( new ProviderPlanExpiring( $renewal , 'week') );
        }
        endif;

        $day = \App\Provider::where('renewal_date', $dayBefore )->get();
        if( $day->isNotEmpty() ):
        foreach($day as $renewal){
            $provider = \App\User::find($renewal->user_id);
            $provider->notify( new ProviderPlanExpiring( $renewal, 'day' ) );
        }
        endif;

        $expired = \App\Provider::where('renewal_date', '<', $today )->get(); 
        if( $expired->isNotEmpty() ):
        foreach($expired as $renewal){
            $provider = \App\User::find($renewal->user_id);
            $provider->notify( new ProviderPlanExpiring( $renewal, 'expired' ) );
        }
        endif;
            

        
        $this->info('ProviderPlan:Status Command Run successfully!');
    }
    
}
