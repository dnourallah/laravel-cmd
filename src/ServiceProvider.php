<?php

namespace DNourallah\LaravelCmd;

use DNourallah\LaravelCmd\Console\ModelGenCommand;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        /*'ScheduleFinish' => ScheduleFinishCommand::class,
        'ScheduleRun' => ScheduleRunCommand::class,
        'StorageLink' => 'command.storage.link',*/
    ];

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $devCommands = [
        //'AuthGen' => 'command.auth.gen',
        'ModelGen' => 'command.model.gen',
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishesFiles();
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/cmd.php', 'command'
        );

        $this->registerCommands(array_merge(
            $this->commands, $this->devCommands
        ));
    }

    public function publishesFiles()
    {
        $this->publishes([
            __DIR__.'/../config/cmd.php' => config_path('cmd.php')
        ], 'config');
    }

    /**
     * Register the given commands.
     *
     * @param  array  $commands
     * @return void
     */
    protected function registerCommands(array $commands)
    {
        foreach (array_keys($commands) as $command) {
            call_user_func_array([$this, "register{$command}Command"], []);
        }

        $this->commands(array_values($commands));
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerModelGenCommand()
    {
        $this->app->singleton('command.model.gen', function ($app) {
            return  new ModelGenCommand($app['files']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array_merge(array_values($this->commands), array_values($this->devCommands));
    }
}