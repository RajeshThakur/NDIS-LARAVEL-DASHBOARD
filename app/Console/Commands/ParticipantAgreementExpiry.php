<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\ParticipantAgreementExpiring;
use Carbon\Carbon;

class ParticipantAgreementExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ParticipantAgreement:Expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if participant Agreement is expiring or expired';

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
        // \Log::info("Running Cron ParticipantPlan:Status!");
        // \Log::info("Looking for participants whose agreement are about to expire");
        $this->info("Running Cron ParticipantPlan:Status");
        $this->info("Looking for participants whose conract are about to expire or expired");
        
        $weekBefore = Carbon::now()->addWeek()->toDateString();
        $monthBefore = Carbon::now()->addMonth()->toDateString();
        $dayBefore = Carbon::now()->addDay()->toDateString();
        $today = Carbon::now()->toDateString();

        $allSignedParticipants = \App\Participant::whereAgreementSigned( 1 )->get();

        if( $allSignedParticipants->isNotEmpty() ): 
            foreach($allSignedParticipants as $parti): //loop through participants who have signed agreement
                $expiryDate = '';
                $agreementFormData = \App\OperationalForms::whereUserId($parti->user_id)->whereTemplateId(config('ndis.forms.particpant_agreement_id'))->pluck('id');
                // dump($agreementFormData);
                if( isset($agreementFormData['0']) ):
                    $expiryDate = \App\OpformMeta::whereOpformId( $agreementFormData['0'] )->whereMetaKey('aggrement_end_date')->pluck('meta_value');
                    // dd(Carbon::parse(unserialize($expiryDate[0])));
                    $expiryDate = Carbon::parse(unserialize($expiryDate[0]))->toDateString();
                    // dump($expiryDate);
                    // dd($weekBefore);
                    // if( $expiryDate->equalTo($monthBefore) ):
                    $participant = \App\User::find($parti->user_id);
                    $provider = \App\User::find($participant->getUserProviders()->first()->provider_id);
                    if( $expiryDate == $monthBefore ):                        
                        $participant->notify( new ParticipantAgreementExpiring( $participant, $provider, $expiryDate, 'month', 'participant' ) );
                        $provider->notify( new ParticipantAgreementExpiring( $participant, $provider, $expiryDate, 'month', 'provider' ) );
                    endif;

                    if( $expiryDate == $dayBefore  ):
                        $participant->notify( new ParticipantAgreementExpiring( $participant, $provider, $expiryDate, 'day', 'participant' ) );
                        $provider->notify( new ParticipantAgreementExpiring( $participant, $provider, $expiryDate, 'day', 'provider' ) );
                    endif;

                    if( $expiryDate == $weekBefore ):
                        $participant->notify( new ParticipantAgreementExpiring( $participant, $provider, $expiryDate, 'week', 'participant' ) );
                        $provider->notify( new ParticipantAgreementExpiring( $participant, $provider, $expiryDate, 'week', 'provider' ) );
                    endif;

                    if( Carbon::parse($expiryDate)->lessThan($today) ):
                        $participant->notify( new ParticipantAgreementExpiring( $participant, $provider, $expiryDate, 'expired', 'participant' ) );
                        $provider->notify( new ParticipantAgreementExpiring( $participant, $provider, $expiryDate, 'expired', 'provider' ) );
                    endif;

                endif;

            endforeach;
        endif;

        $this->info('ParticipantAgreement:Expiry Command Run successfully!');

    }
}
