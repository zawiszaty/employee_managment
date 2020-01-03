<?php

declare(strict_types=1);


namespace App\Infrastructure\Infrastructure;


use App\Infrastructure\Domain\AggregateRoot;
use App\Infrastructure\Domain\EventDispatcher;

abstract class InMemoryRepository
{
    private EventDispatcher $eventDispatcher;

    private array $events;

    public function __construct(EventDispatcher $eventDispatcher)
    {
        $this->events = [];
        $this->eventDispatcher = $eventDispatcher;
    }

    public function save(): void
    {
        foreach ($this->events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }

    public function apply(AggregateRoot $aggregateRoot): void
    {
        $this->events = array_merge($this->events, $aggregateRoot->getUncommittedEvents());
        $aggregateRoot->commitEvents();
    }
}