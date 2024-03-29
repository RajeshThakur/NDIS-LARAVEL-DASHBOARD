<?php

namespace Dmark\Messenger;

use Dmark\Messenger\Models\Message;
use Dmark\Messenger\Models\Models;
use Dmark\Messenger\Models\Participant;
use Dmark\Messenger\Models\Thread;
use Illuminate\Support\ServiceProvider;

class MessengerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->offerPublishing();
        $this->setMessengerModels();
        $this->setUserModel();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->configure();
    }

    /**
     * Setup the configuration for Messenger.
     *
     * @return void
     */
    protected function configure()
    {
        // dd( base_path('config/messenger.php'));
        $this->mergeConfigFrom(
            // base_path('vendor/cmgmyr/messenger/config/config.php'),
            base_path('/packages/dmark/messenger/config/messenger.php'),
            'messenger'
        );
    }

    /**
     * Setup the resource publishing groups for Messenger.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                base_path('packages/dmark/messenger/messenger.php') => config_path('messenger.php'),
            ], 'config');

            $this->publishes([
                base_path('packages/dmark/messenger/migrations') => base_path('database/migrations'),
            ], 'migrations');
        }
    }

    /**
     * Define Messenger's models in registry.
     *
     * @return void
     */
    protected function setMessengerModels()
    {
        $config = $this->app->make('config');
        // dd($config);
        Models::setMessageModel($config->get('messenger.message_model', Message::class));
        Models::setThreadModel($config->get('messenger.thread_model', Thread::class));
        Models::setParticipantModel($config->get('messenger.participant_model', Participant::class));

        Models::setTables([
            'messages' => $config->get('messenger.messages_table', Models::message()->getTable()),
            'participants' => $config->get('messenger.participants_table', Models::participant()->getTable()),
            'threads' => $config->get('messenger.threads_table', Models::thread()->getTable()),
        ]);
    }

    /**
     * Define User model in Messenger's model registry.
     *
     * @return void
     */
    protected function setUserModel()
    {
        $config = $this->app->make('config');

        $model = $config->get('messenger.user_model', function () use ($config) {
            return $config->get('auth.providers.users.model', $config->get('auth.model'));
        });

        Models::setUserModel($model);

        Models::setTables([
            'users' => (new $model)->getTable(),
        ]);
    }
}
