<?php

namespace Clay\Bootstrap\Providers;

use Clay\Bootstrap\Alert\AlertWrapper;
use Illuminate\Support\ServiceProvider;
use Clay\Bootstrap\FieldBuilder;

class BootstrapServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerFieldBuilder();
        $this->registerAlertWrapper();
    }

    public function registerFieldBuilder()
    {
        $this->app['field'] = $this->app->share(function ($app) {
            $fieldBuilder = new FieldBuilder($app['form'], $app['view'], $app['session.store']);

            return $fieldBuilder;
        });
    }

    public function registerAlertWrapper()
    {
        $this->app->bind('alert', function ($app) {
            return new AlertWrapper($app['session.store'], $app['view'], $app['translator']);
        });
    }

}
