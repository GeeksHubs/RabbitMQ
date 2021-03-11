<?php
declare(strict_types=1);

namespace Geekshubs\RabbitMQ;

use PhpAmqpLib\Message\AMQPMessage;

final class RabbitMQ
{
    private Connection $connection;
    private Connection $connection_error;
    public function __construct(string $host, string $port, string $username, string $password, string $vhost)
    {
        $this->connection = new Connection($host,$port,$username,$password,$vhost);
        $this->connection_error = new Connection($host,$port,$username,$password,$vhost);
    }

    public function createConnect(string $queue)
    {
        $this->connection->connect($queue);
        $this->connection_error->connect($queue.'_error');
    }

    public function createExchange(?string $name, ?string $type, ?bool $passive, ?bool $durable, ?bool $auto_delete,?bool $internal, ?bool $wait, ?array $properties):void
    {
        $exchange = new Exchange($this->connection);
        $exchange($name,$type,$passive,$durable,$auto_delete,$internal,$wait,$properties);
        $exchange_error = new Exchange($this->connection_error);
        $exchange_error($name."_error",$type,$passive,$durable,$auto_delete,$internal,$wait,$properties);

    }

    public function publicMessage(string $queue, string $exchange,string  $routing_key, string  $message):void
    {
        $publisher = new Publisher($this->connection);
        $publisher($queue, $exchange,$routing_key,$message);
    }

    public function requestRpc(string $id, string $queue , string $queue_return, string $exchange  , string $routing_key , string $message, bool $resend=false)
    {
        $requestRpc = new RequestRPC($this->connection, $queue_return);
        $result = $requestRpc->call($id,$queue,$queue_return,$exchange,$routing_key,$message);
        if(is_object($result) && get_class($result) === "PhpAmqpLib\Message\AMQPMessage"){
            $this->connection->shutdown();
            if($resend) $requestRpc->resend($this->connection_error,$result->body
                ,$queue."_error", $exchange."_error"  ,$routing_key,$queue_return);
            return null;
        }
        $this->connection->shutdown();
        return $result;
    }

    public function responseRpc(array $message, AMQPMessage $AMQPMessage):void{
        $requestRpc = new RequestRPC($this->connection, $AMQPMessage->get('reply_to'));
        $requestRpc->response($message, $AMQPMessage);
        $this->connection->shutdown();
    }
}