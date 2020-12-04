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
        $this->app->singleton('rabbitmq', function ($app) {
            return new RabbitMQ();
        });
    }

    public function provides()
    {
        return[
            'RabbitMQ',

        ];
    }
}