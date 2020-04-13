<?php

declare(strict_types=1);

namespace App\Infrastructure\Infrastructure\Rabbit;

use App\Infrastructure\Domain\Event;
use App\Infrastructure\Domain\EventDispatcher;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

final class Consumer
{
    private const QUEUE = 'monolith';

    private EventsRabbitConfig $eventsRabbitConfig;

    private EventDispatcher $eventDispatcher;

    private string $exchange;

    private string $locale;

    private AMQPChannel $channel;

    public function __construct(
        AMQPStreamConnection $connection,
        EventsRabbitConfig $eventsRabbitConfig,
        EventDispatcher $eventDispatcher,
        string $exchange,
        string $locale
    ) {
        $this->eventsRabbitConfig = $eventsRabbitConfig;
        $this->eventDispatcher = $eventDispatcher;
        $this->exchange = $exchange;
        $this->locale = $locale;
        $this->channel = $connection->channel();
    }

    public function consume(): void
    {
        $this->channel->queue_bind(sprintf('%s.%s', $this->locale, self::QUEUE), $this->exchange, sprintf('%s.#', $this->locale));
        $this->channel->basic_consume(sprintf('%s.%s', $this->locale, self::QUEUE), '', false, true, false, false, function (AMQPMessage $msg) {
            $decodesMessage = json_decode($msg->getBody(), true);
            $routing_key = $decodesMessage['routing_key'];

            if (false === $this->eventsRabbitConfig->hasByRoutingKey($routing_key)) {
                echo sprintf('[x] ERROR: routing_key %s not found in configuration', $routing_key);

                return;
            }
            $namespace = $this->eventsRabbitConfig->getByRoutingKey($routing_key);
            $event = call_user_func([$namespace, 'fromArray'], $decodesMessage['payload']);

            if (false === $event instanceof Event) {
                echo sprintf('[x] ERROR: Wrong Payload for event: %s', $namespace);

                return;
            }

            $this->eventDispatcher->dispatch($event);
        });

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }
}
