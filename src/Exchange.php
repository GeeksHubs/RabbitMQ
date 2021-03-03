<?php
declare(strict_types=1);

namespace Geekshubs\RabbitMQ;

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
            throw new \Exception("Error no connection created");
        }


    }

    public function __invoke(?string $exchange, ?string $type, ?bool $passive, ?bool $durable, ?bool $auto_delete,?bool $internal, ?bool $wait, ?array $properties):void
    {
        try {
             $this->channel->exchange_declare(
                !is_null($exchange)?$exchange:null,
                !is_null($type)?$type: null,
                !is_null($passive)? $passive: null,
                !is_null($durable)?$durable: null,
                !is_null($auto_delete)?$auto_delete: null,
                !is_null($internal)?$internal: null,
                !is_null($wait)? $wait: null,
                !is_null($properties)?$properties:null
            );
        }catch(\Exception $ex){
            throw new \Exception("Error to create exchange->".$ex->getMessage());

        }
    }

}