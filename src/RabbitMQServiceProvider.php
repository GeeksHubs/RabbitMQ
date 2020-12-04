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

    }

    public function provides()
    {
        return[
            'RabbitMQ',

        ];
    }
}