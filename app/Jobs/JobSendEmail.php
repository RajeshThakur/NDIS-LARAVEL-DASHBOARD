<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class JobSendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $email = null;
    private $mailto = null;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $mailto)
    {
        $this->email = $email;
        $this->mailto = $mailto;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            Mail::to($this->mailto)->send($this->email);
        }
        catch(\Exception $e){
            \Log::critical( [ 'Message' => $e->getMessage(), 'file' => $e->getFile(), 'line'=>$e->getLine() ] );
        }
        
    }
}
