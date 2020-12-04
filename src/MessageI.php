<?php


namespace Geekshubs\RabbitMQ;


use PhpAmqpLib\Message\AMQPMessage;

interface MessageI
{
    public function Message(AMQPMessage $message):void;

}