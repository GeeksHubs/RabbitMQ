<?php


namespace Geekshubs\RabbitMQ;
use Illuminate\Support\ServiceProvider;

class RabbitMQServiceProvider extends ServiceProvider
{
    protected $defer=false;

    public function boot()
    {
    }

    public function register()
    {
        $this->app->singleton(RabbitMQ::class, function ($app) {
            return new RabbitMQ($app);
        });
    }

    public function provides()
    {
        return[
            'RabbitMQ',

        ];
    }
}