<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Controllers\Traits\OpformTrait;
use App\Notifications\AgreementPendingParticipant;

class ParticipantAgreement extends Command
{
    
    use OpformTrait;

    protected $log_id;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Agreement:Participant';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron job to check and notifiy Participants for any agreement not signed';


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
    private function logCron($data){
        
        if(!$this->log_id){
            $cron = \App\CronLogs::create([
                'command_name' => $this->signature,
                'data' => json_encode($data),
                'started_at' => \Carbon\Carbon::now()
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
        $dateTimePrior = \Carbon\Carbon::now()->subDays( config('ndis.notification.agreement_time_gap') )->format( config('panel.db_datetime_format') );

        logMsg("Looking for particpant who haven't signed the agreement before :".$dateTimePrior);

        // We are Fetaching all Participants who haven't signed the agreement for all Providers
        $participantsWithoutAgreement = \App\Participant::where('participants_details.agreement_signed', 0 )
                                        ->whereDate('participants_details.created_at', '<=', $dateTimePrior )
                                        ->get();
        

        //confirm if the Participant's Agreement is pending??
        foreach($participantsWithoutAgreement as $participant){
            $agreements = $this->participantAgreements( $participant->user_id )->get();
            if($agreements->count()){
                // foreach($agreements as $agreement){
                    
                // }
                if(!$participant->agreement_signed)
                    $participant->user->notify( new AgreementPendingParticipant($participant) );
            }
            else{
                $participant->user->notify( new AgreementPendingParticipant($participant) );
            }
        }
        

    }
}