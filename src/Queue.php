<?php
declare(strict_types=1);

namespace Geekshubs\RabbitMQ;


use ApiGateway\Common\Infraestructure\Services\RabbitMQ\Connection;
use Illuminate\Support\Facades\Log;
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
        }catch (Exception $ex){
            log::error("Error en la creación de la cola ". $ex->getMessage());
        }
    }

    public function purgeQueue(string $queue):void
    {
        log::info("Vaciando la cola ->".$queue);
        try {
            $this->channel->queue_purge($queue);
        }catch(Exception $ex){
            log::error("Error al vaciar la cola ->".$queue);
        }
    }

    public function deleteQueue(string $queue):void
    {
        log::info("Eliminando la cola ->".$queue);
        try{
            $this->channel->queue_delete($queue);
        }catch(Exception $ex){
            log::error("Error al eliminar la cola ->".$queue);
        }
    }
}