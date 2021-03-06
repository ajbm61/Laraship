<?php

namespace Corals\Foundation\Providers;

use Illuminate\Support\ServiceProvider;

class BaseUninstallModuleServiceProvider extends ServiceProvider
{
    protected $migrations = [];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->booted(function () {
            $this->booted();
            \Cache::flush();

        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    protected function booted()
    {
    }

    protected function dropSchema($reverseMigrations = true)
    {
        if ($reverseMigrations) {
            $migrations = array_reverse($this->migrations);
        } else {
            $migrations = $this->migrations;
        }

        foreach ($migrations as $migration) {
            $migrationObject = new $migration();
            $migrationObject->down();
        }
    }
}
