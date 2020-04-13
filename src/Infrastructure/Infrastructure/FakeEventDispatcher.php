<?php

declare(strict_types=1);

namespace App\Infrastructure\Infrastructure;

use App\Infrastructure\Domain\Event;
use App\Infrastructure\Domain\EventDispatcher;

final class FakeEventDispatcher implements EventDispatcher
{
    private array $events = [];

    public function dispatch(Event ...$events): void
    {
        $this->events = array_merge($this->events, $events);
    }

    public function getEvents(): array
    {
        return $this->events;
    }

    public function popEvents(): void
    {
        $this->events = [];
    }
}
