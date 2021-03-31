<?php

namespace FWRD\Laravel\Freshdesk;

use Illuminate\Support\ServiceProvider;

class FreshdeskServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    \dirname(__DIR__) . '/config/freshdesk.php' => \config_path('freshdesk.php'),
                ]
            );
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            \dirname(__DIR__) . '/config/freshdesk.php',
            'freshdesk'
        );

        $this->app->singleton('freshdesk', function ($app) {
            $config = $app->make('config')->get('freshdesk');
            return new Api($config['api_key'], $config['domain']);
        });

        $this->app->alias('freshdesk', Api::class);
    }

//    public function provides()
//    {
//        return ['freshdesk', Api::class];
//    }
}
