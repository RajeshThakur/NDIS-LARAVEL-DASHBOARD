<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\WorkerAgreementExpiring;
use Carbon\Carbon;

class WorkerAgreementExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'WorkerAgreement:Expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if worker contract is expiring or is expired';

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
        $this->info("Running Cron WorkerAgreement:Expiry");
        $this->info("Looking for workers whose conract are about to expire or expired");

        $weekBefore = Carbon::now()->addWeek()->toDateString();
        $monthBefore = Carbon::now()->addMonth()->toDateString();
        $dayBefore = Carbon::now()->addDay()->toDateString();
        $today = Carbon::now()->toDateString();

        $allSignedWorkers = \App\SupportWorker::whereAgreementSigned( 1 )->get();

        if( $allSignedWorkers->isNotEmpty() ): 
            foreach($allSignedWorkers as $worker): //loop through workers who have signed agreement

                $expiryDate = '';
                $agreementFormData = \App\OperationalForms::whereUserId($worker->user_id)->whereTemplateId(config('ndis.forms.support_worker_agreement_id'))->pluck('id');

                if( isset($agreementFormData['0']) ):
                    $expiryDate = \App\OpformMeta::whereOpformId( $agreementFormData['0'] )->whereMetaKey('agreement_probationary_date')->pluck('meta_value');
                    $expiryDate = Carbon::parse(unserialize($expiryDate[0]))->toDateString();

                    $sw = \App\User::find($worker->user_id);
                    $provider = \App\User::find($sw->getUserProviders()->first()->provider_id);

                    if( $expiryDate == $monthBefore ):                        
                        $sw->notify( new WorkerAgreementExpiring( $sw, $provider, $expiryDate, 'month', 'worker' ) );
                        $provider->notify( new WorkerAgreementExpiring( $sw, $provider, $expiryDate, 'month', 'provider' ) );
                    endif;

                    if( $expiryDate == $dayBefore  ):
                        $sw->notify( new WorkerAgreementExpiring( $sw, $provider, $expiryDate, 'day', 'worker' ) );
                        $provider->notify( new WorkerAgreementExpiring( $sw, $provider, $expiryDate, 'day', 'provider' ) );
                    endif;

                    if( $expiryDate == $weekBefore ):
                        $sw->notify( new WorkerAgreementExpiring( $sw, $provider, $expiryDate, 'week', 'worker' ) );
                        $provider->notify( new WorkerAgreementExpiring( $sw, $provider, $expiryDate, 'week', 'provider' ) );
                    endif;

                    if( Carbon::parse($expiryDate)->lessThan($today) ):
                        $sw->notify( new WorkerAgreementExpiring( $sw, $provider, $expiryDate, 'expired', 'worker' ) );
                        $provider->notify( new WorkerAgreementExpiring( $sw, $provider, $expiryDate, 'expired', 'provider' ) );
                    endif;
                endif;

            endforeach;
        endif;


        $this->info('WorkerAgreement:Expiry Command Run successfully');

    }
}
