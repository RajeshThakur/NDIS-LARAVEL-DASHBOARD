<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\ParticipantPlanExpiring;
use Carbon\Carbon;

class ParticipantPlanStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ParticipantPlan:Status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if NDIS plan of participant is expiring';

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
        \Log::info("Running Cron ParticipantPlan:Status!");
        $this->info("Running Cron ParticipantPlan:Status!");
        // Database Operations here        

        \Log::info("Looking for participants whose NDIS plan are about to expire");
        $this->info("Looking for participants whose NDIS plan are about to expire");
        
        $weekBefore = Carbon::now()->addWeek()->toDateString();
        $monthBefore = Carbon::now()->addMonth()->toDateString();
        $dayBefore = Carbon::now()->addDay()->toDateString();
        $today = Carbon::now()->toDateString();
        
        $month = \App\Participant::where('end_date_ndis', $monthBefore )->get();
        if( $month->isNotEmpty() ):
            foreach($month as $renewal){
                $participant = \App\User::find($renewal->user_id);    
                $participant->load('participant');            
                $provider = \App\User::find($participant->getUserProviders()->first()->provider_id);
                $participant->notify( new ParticipantPlanExpiring( $participant, $provider, 'month', 'participant' ) );
                $provider->notify( new ParticipantPlanExpiring( $participant, $provider, 'month', 'provider' ) );
            }
        endif;

        $week = \App\Participant::where('end_date_ndis', $weekBefore )->get();
        if( $week->isNotEmpty() ):
        foreach($week as $renewal){
            $participant = \App\User::find($renewal->user_id);
            $participant->load('participant');
            $provider = \App\User::find($participant->getUserProviders()->first()->provider_id);
            $participant->notify( new ParticipantPlanExpiring( $participant, $provider, 'week', 'participant' ) );
            $provider->notify( new ParticipantPlanExpiring( $participant, $provider, 'week', 'provider' ) );
        }
        endif;

        $day = \App\Participant::where('end_date_ndis', $dayBefore )->get();
        if( $day->isNotEmpty() ):
        foreach($day as $renewal){
            $participant = \App\User::find($renewal->user_id);
            $participant->load('participant');
            $provider = \App\User::find($participant->getUserProviders()->first()->provider_id);
            $participant->notify( new ParticipantPlanExpiring( $participant, $provider, 'day', 'participant' ) );
            $provider->notify( new ParticipantPlanExpiring( $participant, $provider, 'day', 'provider' ) );
        }
        endif;

        $expired = \App\Participant::where('end_date_ndis', '<', $today )->get();
        if( $expired->isNotEmpty() ):
            foreach($expired as $renewal){
                $participant = \App\User::find($renewal->user_id);
                $participant->load('participant');
                $provider = \App\User::find($participant->getUserProviders()->first()->provider_id);
                $participant->notify( new ParticipantPlanExpiring( $participant, $provider, 'expired', 'participant' ) );
                $provider->notify( new ParticipantPlanExpiring( $participant, $provider, 'expired', 'provider' ) );
            }
        endif;

        
        $this->info('ParticipantPlan:Status command executed successfully!');
    }
}
