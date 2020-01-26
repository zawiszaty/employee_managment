<?php

declare(strict_types=1);

namespace App\Infrastructure\Infrastructure;

use App\Infrastructure\Domain\Event;
use App\Infrastructure\Domain\EventPublisher;

final class EventDispatcher implements \App\Infrastructure\Domain\EventDispatcher
{
    private array $eventsPublishers = [];

    public function dispatch(Event $event): void
    {
        array_map(static function (EventPublisher $eventPublisher) use ($event) {
            if ($eventPublisher->supports($event))
            {
                $eventPublisher->dispatch($event);
            }
        }, $this->eventsPublishers);
    }

    public function addEventPublisher(EventPublisher $eventPublisher): void
    {
        $this->eventsPublishers[] = $eventPublisher;
    }
}