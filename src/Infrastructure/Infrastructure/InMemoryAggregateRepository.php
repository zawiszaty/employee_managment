<?php

declare(strict_types=1);

namespace App\Infrastructure\Infrastructure;

use App\Infrastructure\Domain\AggregateRoot;
use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\EventDispatcher;

abstract class InMemoryAggregateRepository
{
    private EventDispatcher $eventDispatcher;

    private array $events;

    /** @var array<AggregateRoot> */
    private array $aggregates = [];

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
        $this->events = [];
    }

    public function get(AggregateRootId $aggregateRootId): AggregateRoot
    {
        return $this->aggregates[$aggregateRootId->toString()];
    }

    public function apply(AggregateRoot $aggregateRoot): void
    {
        $this->events = array_merge($this->events, $aggregateRoot->getUncommittedEvents());
        $aggregateRoot->commitEvents();
        $this->aggregates[$aggregateRoot->getId()->toString()] = $aggregateRoot;
    }
}
