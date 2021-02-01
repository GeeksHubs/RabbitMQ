<?php
declare(strict_types=1);

namespace Geekshubs\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

final class Connection
{
    private ?string $host;
    private ?string $port;
    private ?string $username;
    private ?string $password;
    private ?string $vhost;
    private ?string $queue;

    private  AMQPStreamConnection $connection;
    private ?AMQPChannel $channel = null;

    public function __construct()
    {

        $this->host= config('RABBITMQ_HOST','milgestiones_rabbit');
        $this->port= config('RABBITMQ_PORT','5672');
        $this->username= config('RABBITMQ_USERNAME','rabbitmq');
        $this->password= config('RABBITMQ_PASSWORD','rabbitmq');
        $this->vhost = config('RABBITMQ_VHOST','/');

    }

    public function connect(string $queue): ?AMQPStreamConnection
    {
        $this->queue = $queue;
        try {
            $this->connection = new AMQPStreamConnection(
                $this->host,
                $this->port,
                $this->username,
                $this->password,
                $this->vhost
            );
            $this->channel = $this->connection->channel();
            $this->channel->queue_declare($this->queue, false, true, false, false);
            return $this->connection;
        }catch (\Exception $ex){
             throw  new \Exception("Error ->".$ex-getmessage());
             return null;
        }
    }

    public function getConnection(): AMQPStreamConnection{
        return $this->connection;
    }

    public function getChannel():?AMQPChannel
    {

        return ($this->channel)?$this->channel:null;
    }

    public function Queue():string
    {
        return $this->queue;
    }

    public function shutdown(){
        $this->channel->close();
        try {
            $this->connection->close();
        } catch (\Exception $e) {
            throw new \Exception("Error to close connection->". $e->getMessage());
        }
    }
}