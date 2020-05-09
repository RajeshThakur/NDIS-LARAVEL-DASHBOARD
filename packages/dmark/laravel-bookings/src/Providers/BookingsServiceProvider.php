<?php

declare(strict_types=1);

namespace Dmark\Bookings\Providers;

use Illuminate\Support\ServiceProvider;
use Dmark\Support\Traits\ConsoleTools;
use Dmark\Bookings\Console\Commands\MigrateCommand;
use Dmark\Bookings\Console\Commands\PublishCommand;
use Dmark\Bookings\Console\Commands\RollbackCommand;

class BookingsServiceProvider extends ServiceProvider
{
    use ConsoleTools;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        MigrateCommand::class => 'command.dmark.bookings.migrate',
        PublishCommand::class => 'command.dmark.bookings.publish',
        RollbackCommand::class => 'command.dmark.bookings.rollback',
    ];

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(realpath(__DIR__.'/../../config/config.php'), 'dmark.bookings');

        // Register console commands
        ! $this->app->runningInConsole() || $this->registerCommands();
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Publish Resources
        ! $this->app->runningInConsole() || $this->publishesConfig('dmark/laravel-bookings');
        ! $this->app->runningInConsole() || $this->publishesMigrations('dmark/laravel-bookings');
    }
}
