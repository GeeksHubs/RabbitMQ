<?php
declare(strict_types=1);

namespace Geekshubs\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;

final class Consumer
{
    private ?AMQPChannel $channel;
    private Connection $connection;
    private MessageI $messageObject;
    public function __construct(Connection $connection,MessageI  $messageObject)
    {

        $this->connection = $connection;
        $this->channel = $connection->getChannel();
        $this->messageObject = $messageObject;

    }

    public function __invoke(string $queue='', string $exchange='', $routing_key=''):void
    {


            $callback = function ($msg) {
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
                $this->messageReceived($msg);
            };

            $this->channel->queue_bind($queue,$exchange,$routing_key);

            $this->channel->basic_qos(null,1,null);
            $this->channel->basic_consume($queue,
                '',
                false,
                false,
                false,
                false,
                $callback
            );

            while (count($this->channel->callbacks)) {
                  $this->channel->wait();
            }

    }
    public function messageReceived($msg):void{
        $this->messageObject->Message($msg);
    }
}