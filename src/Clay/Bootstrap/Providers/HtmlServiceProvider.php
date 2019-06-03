<?php

namespace Clay\Bootstrap\Providers;

use Clay\Bootstrap\FormBuilder;
use Illuminate\Html\HtmlServiceProvider as ServiceProvider;

class HtmlServiceProvider extends ServiceProvider
{
    /**
     * Register the form builder instance.
     *
     * @return void
     */
    protected function registerFormBuilder()
    {
        $this->app->singleton('form', function($app) {
            $form = new FormBuilder($app['html'], $app['url'], $app['session.store']->getToken());

            $form->setNovalidate($app['config']->get('app.novalidate', false));

            return $form->setSessionStore($app['session.store']);
        });
    }
}
