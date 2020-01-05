<?php

declare(strict_types=1);

namespace App\Infrastructure\Infrastructure;

use App\Infrastructure\Domain\Event;
use App\Infrastructure\Domain\EventDispatcher;

final class InMemoryEventDispatcher implements EventDispatcher
{
    private array $events;

    public function dispatch(Event $event): void
    {
        $this->events[] = $event;
    }

    public function getEvents(): array
    {
        return $this->events;
    }
}
