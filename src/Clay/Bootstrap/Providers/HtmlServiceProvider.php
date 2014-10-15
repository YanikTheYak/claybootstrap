<?php

namespace Bootstrap\Providers;

use Bootstrap\FormBuilder,
    Illuminate\Html\HtmlServiceProvider as ServiceProvider;

class HtmlServiceProvider extends ServiceProvider
{
    /**
     * Register the form builder instance.
     *
     * @return void
     */
    protected function registerFormBuilder()
    {
        $this->app['form'] = $this->app->share(function ($app) {
            $form = new FormBuilder($app['html'], $app['url'], $app['session.store']->getToken());

            $form->setNovalidate($app['config']->get('app.novalidate', false));

            return $form->setSessionStore($app['session.store']);
        });
    }
}
