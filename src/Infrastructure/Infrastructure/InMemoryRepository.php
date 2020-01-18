<?php

declare(strict_types=1);

namespace App\Infrastructure\Infrastructure;

use App\Infrastructure\Domain\EventDispatcher;
use App\Infrastructure\Domain\Uuid;

abstract class InMemoryRepository
{
    private EventDispatcher $eventDispatcher;

    private array $events;

    protected array $aggregates = [];

    public function __construct()
    {
        $this->events = [];
    }

    public function save(): void
    {
        $this->events = [];
    }

    public function get(Uuid $aggregateRootId): object
    {
        return $this->aggregates[$aggregateRootId->toString()];
    }

    public function apply($aggregateRoot): void
    {
        $this->aggregates[] = $aggregateRoot;
    }
}
