<?php
declare(strict_types=1);

namespace Geekshubs\RabbitMQ;

use PhpAmqpLib\Message\AMQPMessage;

final class RabbitMQ
{
    private Connection $connection;
    public function __construct()
    {
        $this->connection = new Connection();

    }
    public function createConnect(string $queue)
    {
        $this->connection->connect($queue);
    }

    public function createExchange(?string $name, ?string $type, ?bool $passive, ?bool $durable, ?bool $auto_delete,?bool $internal, ?bool $wait, ?array $properties):void
    {
        $exchange = new Exchange($this->connection);
        $exchange($name,$type,$passive,$durable,$auto_delete,$internal,$wait,$properties);

    }

    public function publicMessage(string $queue, string $exchange,string  $routing_key, string  $message):void
    {
        $publisher = new Publisher($this->connection);
        $publisher($queue, $exchange,$routing_key,$message);
    }

    public function requestRpc(string $id, string $queue , string $queue_return, string $exchange  , string $routing_key , string $message)
    {
        $requestRpc = new RequestRPC($this->connection, $queue_return);
        $result = $requestRpc->call($id,$queue,$queue_return,$exchange,$routing_key,$message);
        $this->connection->shutdown();
        return $result;
    }

    public function responseRpc(array $message, AMQPMessage $AMQPMessage):void{
        $requestRpc = new RequestRPC($this->connection, $AMQPMessage->get('reply_to'));
        $requestRpc->response($message, $AMQPMessage);
    }
}