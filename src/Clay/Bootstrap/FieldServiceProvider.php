<?php

namespace Clay\Bootstrap;

use Illuminate\Support\ServiceProvider;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('field', function($app) {
            $fieldBuilder = new FieldBuilder($app['form'], $app['view'], $app['session.store']);

            return $fieldBuilder;
        });
    }

}
