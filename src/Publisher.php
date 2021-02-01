<?php


namespace Geekshubs\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

final class Publisher
{
    private ?AMQPChannel $channel;
    private  Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection= $connection;
        $this->channel = $connection->getChannel();
    }

    public function  __invoke(string $queue = "", string $exchange="",string  $routing_key="anonymous.info", string  $message=""):void
    {
       try {
            $this->channel->queue_bind($queue,$exchange,$routing_key);
            $message = new AMQPMessage(
                $message,
                array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
            );
            $this->channel->basic_publish($message, $exchange, $routing_key);
        } catch (\Exception $ex) {
            throw new \Exception("Error ->". $ex->getMessage());
        } finally {
            $this->connection->shutdown();
        }
    }
}