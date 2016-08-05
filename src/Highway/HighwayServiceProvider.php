<?php

namespace Larablocks\Highway;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;


/**
 * Class HighwayServiceProvider
 * @package Larablocks\Highway
 */
class HighwayServiceProvider extends ServiceProvider
{

    public function register()
    {
        // Required for testing
        //require __DIR__ . '../../../bootstrap/autoload.php';

        // Bind the Highway Class to the facade
        $this->app->bind('highway', 'Larablocks\Highway\Highway');

        // Load Highway alias for the user if not set in app.php
        $aliases = config('app.aliases');
        if (empty($aliases['Highway'])) {
            AliasLoader::getInstance()->alias('Highway', 'Larablocks\Highway\Facade\Highway');
        }
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/highway.php' => config_path('highway.php'),
        ], 'config');
    }

}