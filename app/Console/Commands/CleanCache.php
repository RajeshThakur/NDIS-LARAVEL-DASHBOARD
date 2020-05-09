<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to clean all application (config,view,route and app cache) cache';

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
        $this->info('Clearing all application caches....');

        //remove cached configurations
        \Artisan::call('cache:clear');
        \Artisan::call('config:clear');
        \Artisan::call('route:clear');
        \Artisan::call('view:clear');

        $this->info('All application caches cleared!');

        $this->info('Creating new application caches....');
        //create configuration cache
        \Artisan::call('view:cache');
        \Artisan::call('config:cache');
        \Artisan::call('route:cache');

        $this->info('All application caches generated!');
    }
}
