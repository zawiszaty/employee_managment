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

    public function __construct()
    {
        $this->events = [];
    }

    public function save(): void
    {
        $this->events = [];
    }

    public function get(AggregateRootId $aggregateRootId): AggregateRoot
    {
        return $this->aggregates[$aggregateRootId->toString()];
    }

    public function apply(AggregateRoot $aggregateRoot): void
    {
        $this->aggregates[$aggregateRoot->getId()->toString()] = $aggregateRoot;
    }
}
