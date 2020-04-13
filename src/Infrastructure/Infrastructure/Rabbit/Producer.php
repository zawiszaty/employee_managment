<?php

declare(strict_types=1);

namespace App\Infrastructure\Infrastructure\Rabbit;

use App\Infrastructure\Domain\Event;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

final class Producer
{
    private AMQPChannel $channel;

    private string $exchange;

    private string $locale;

    private EventsRabbitConfig $config;

    public function __construct(
        AMQPStreamConnection $connection,
        string $exchange,
        string $locale,
        EventsRabbitConfig $config
    ) {
        $this->exchange = $exchange;
        $this->locale = $locale;
        $this->config = $config;
        $this->channel = $connection->channel();
        $this->channel->exchange_declare($this->exchange, 'fanout', false, false, false);
    }

    public function produce(Event $event): void
    {
        $payload = [
            'routing_key' => $this->config->getByNamespace(get_class($event)),
            'payload' => $event->toArray(),
        ];

        if (false === $this->config->hasByNamespace(get_class($event))) {
            return;
        }
        $this->channel->basic_publish(new AMQPMessage(json_encode($payload)), $this->exchange, sprintf('%s.%s', $this->locale, $this->config->getByNamespace(get_class($event))));
    }
}
