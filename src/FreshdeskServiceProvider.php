<?php

namespace FWRD\Laravel\Freshdesk;

use Illuminate\Support\ServiceProvider;

class FreshdeskServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            \dirname(__DIR__) . '/config/freshdesk.php' => \config_path('freshdesk.php'),
        ]);

        if ($this->app->runningInConsole()) {
            //
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            \dirname(__DIR__) . '/config/freshdesk.php',
            'freshdesk'
        );

        $this->app->singleton(Api::class, function ($app) {
            return new Api(
                \config('freshdesk.api_key'),
                \config('freshdesk.domain')
            );
        });

        $this->app->alias(Api::class, 'freshdesk');

        parent::register();
    }

    /**
     * @return string[]|array
     */
    public function provides(): array
    {
        return ['freshdesk', Api::class];
    }
}
