<?php
declare(strict_types=1);

namespace Geekshubs\RabbitMQ;



use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Channel\AMQPChannel;

final class Exchange
{
    private ?AMQPChannel $channel;
    private ?string $exchange;
    private ?string $exchange_type;
    private Bool $exchange_passive;
    private Bool $exchange_durable;
    private Bool $exchange_auto_delete;
    private Bool $exchange_internal;
    private Bool $exchange_nowait;
    private Array $exchange_properties;

    public function __construct(?Connection $connection)
    {

        if (!is_null($connection->getChannel())){
            $this->channel = $connection->getChannel();
        }else{
            $connection->connect("employee");
            $this->channel = $connection->getChannel();
        }

        $this->exchange= config('RABBITMQ_EXCHANGE','topic.bussines');
        $this->exchange_type= config('RABBITMQ_EXCHANGE_TYPE','topic');
        $this->exchange_passive= config('RABBITMQ_EXCHANGE_PASSIVE',false);
        $this->exchange_durable= config('RABBITMQ_EXCHANGE_DURABLE',true);
        $this->exchange_auto_delete = config('RABBITMQ_AUTO_DELETE',false);
        $this->exchange_internal = config ('RABBITMQ_EXCHANGE_INTERNAL', false);
        $this->exchange_nowait = config ('RABBIT_EXCHANGE_NOWAIT', false);
        $this->exchange_properties = config ('RABBIT_EXCHANGE_PROPERTIES', []);
    }

    public function __invoke(?string $exchange, ?string $type, ?bool $passive, ?bool $durable, ?bool $auto_delete,?bool $internal, ?bool $wait, ?array $properties):void
    {
        try {
            log::info("Creando el exchange " .  $exchange);
            $this->channel->exchange_declare(
                !is_null($exchange)?$exchange:$this->exchange,
                !is_null($type)?$type: $this->exchange_type,
                !is_null($passive)? $passive: $this->exchange_passive,
                !is_null($durable)?$durable: $this->exchange_durable,
                !is_null($auto_delete)?$auto_delete: $this->exchange_auto_delete,
                !is_null($internal)?$internal:$this->exchange_internal,
                !is_null($wait)? $wait: $this->exchange_nowait,
                !is_null($properties)?$properties:$this->exchange_properties
            );
        }catch(\Exception $ex){
            log::error("Error al crear el exchange " . $ex->getMessage());
        }
    }

}