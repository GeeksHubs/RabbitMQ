<?php


namespace Geekshubs\RabbitMQ;


use PhpAmqpLib\Message\AMQPMessage;

interface MessageI
{
    public function getMessage():AMQPMessage;

}