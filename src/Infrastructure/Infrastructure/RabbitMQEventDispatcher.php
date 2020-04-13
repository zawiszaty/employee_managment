<?php

declare(strict_types=1);

namespace App\Infrastructure\Infrastructure;

use App\Infrastructure\Domain\Event;
use App\Infrastructure\Infrastructure\Rabbit\EventsRabbitConfig;
use App\Infrastructure\Infrastructure\Rabbit\Producer;

final class RabbitMQEventDispatcher implements \App\Infrastructure\Domain\EventDispatcher
{
    private Producer $producer;

    private EventsRabbitConfig $eventsRabbitConfig;

    public function __construct(Producer $producer)
    {
        $this->producer = $producer;
    }

    public function dispatch(Event ...$events): void
    {
        array_map(function (Event $event) {
            $this->producer->produce($event);
        }, $events);
    }
}
