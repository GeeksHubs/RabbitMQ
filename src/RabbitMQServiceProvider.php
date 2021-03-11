<?php


namespace Geekshubs\RabbitMQ;
use Illuminate\Support\ServiceProvider;

class RabbitMQServiceProvider extends ServiceProvider
{
    protected $defer=false;


    public function register()
    {
        $this->app->singleton('RabbitMQ', function ($app) {
            return new RabbitMQ(env('RABBITMQ_HOST','localhost'),
                env('RABBITMQ_PORT','5667'),
                env('RABBITMQ_USERNAME','rabbitmq'),
                env('RABBITMQ_PASSWORD','rabbitmq'),
                env('RABBITMQ_VHOST', '/'));
        });
    }

    public function provides()
    {
        return[
            'RabbitMQ',
        ];
    }
}