<?php
declare(strict_types=1);

namespace Geekshubs\RabbitMQ;

use Mockery\Exception;
use PhpAmqpLib\Channel\AMQPChannel;

final class Queue
{
    private ?AMQPChannel $channel;

    public function __construct(Connection $connection)
    {
        $this->channel = $connection->getChannel();
    }

    public function __invoke(string $queue, string $exchange):void
    {
        try {
            $this->channel->queue_declare($queue, false, true, false, false, false);
        }catch (\Exception $ex){
            throw new \Exception("Error to create queue ->" .$ex->getMessage());

        }
    }

    public function purgeQueue(string $queue):void
    {
        try {
            $this->channel->queue_purge($queue);
        }catch(\Exception $ex){
            throw new \Exception("Error to void queue ->". $ex->getMessage());
        }
    }

    public function deleteQueue(string $queue):void
    {
         try{
            $this->channel->queue_delete($queue);
        }catch(\Exception $ex){
            throw new \Exception("Error to delete Queue ->".$ex->getMessage());
        }
    }
}