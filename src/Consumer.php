<?php
declare(strict_types=1);

namespace Geekshubs\RabbitMQ;


use Illuminate\Support\Facades\Log;
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
        try {

            $callback = function ($msg) {
                log::info("Mensaje ->" .$msg->delivery_info['routing_key']." mensaje -> ".$msg->body);
                log::info("Ack ->".$msg->delivery_info['delivery_tag']);
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
                $this->messageReceived($msg);
            };

            $this->channel->queue_bind($queue,$exchange,$routing_key);

            Log::info("Entrando al consumidor con la cola ->" . $queue);

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
                log::info("Esperando mensajes en cola ->". count($this->channel->callbacks) );
                $this->channel->wait(null,false,5);
            }

        } catch (\Exception $ex) {
            log::error("Error en el consumo de mensajes ->". $ex->getMessage());
        } finally {
            log::info("Cerrando la conexión");
            $this->connection->shutdown();
        }

    }
    public function messageReceived($msg):void{
        $this->messageObject->Message($msg);
    }
}