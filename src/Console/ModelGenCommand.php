<?php

namespace DNourallah\LaravelCmd\Console;

use Illuminate\Foundation\Console\ModelMakeCommand;
use Symfony\Component\Console\Input\InputOption;

class ModelGenCommand extends ModelMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'gen:model';

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        if ($this->option('backend')) {
            return $rootNamespace . '\Models\/' . config('cmd.namespaces.backend.models');
        }

        if ($this->option('site')) {
            return $rootNamespace . '\Models\/' . config('cmd.namespaces.frontend.models');
        }

        return $rootNamespace . '\Models';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        $myOptions = [
            ['backend', 'b', InputOption::VALUE_NONE, 'Create a new Eloquent model class for backend'],

            ['site', 's', InputOption::VALUE_NONE, 'Create a new Eloquent model class for frontend'],
        ];

        return array_merge($myOptions, parent::getOptions());
    }
}