<?php


namespace Geekshubs\RabbitMQ;


class RabbitMQServiceProvider extends ServiceProvider
{
    protected $defer=false;

    public function boot()
    {
    }

    public function register()
    {

    }

    public function provides()
    {
        return[
            'RabbitMQ',

        ];
    }
}