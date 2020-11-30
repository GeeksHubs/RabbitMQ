<?php


namespace Geekshubs\RabbitMQ;


use ApiGateway\Common\Infraestructure\Services\RabbitMQ\Connection;
use Illuminate\Support\Facades\Log;
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
        log::info("Publicando mensaje en la ruta ->".$routing_key);
        try {
            $this->channel->queue_bind($queue,$exchange,$routing_key);
            $message = new AMQPMessage(
                $message,
                array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
            );
            $this->channel->basic_publish($message, $exchange, $routing_key);
        } catch (\Exception $ex) {
            Log::error("Error  ->" . $ex->getMessage());
        } finally {
            log::info("Cerrando la conexión");
            $this->connection->shutdown();
        }
    }
}