<?php

declare(strict_types=1);

namespace App\Module\Employee\Infrastructure\Repository;

use App\Infrastructure\Domain\AggregateRoot;
use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\EventDispatcher;
use App\Infrastructure\Domain\Projector;
use App\Module\Employee\Domain\Employee;
use App\Module\Employee\Domain\EmployeeRepositoryInterface;

final class EmployeeAggregateRepository implements EmployeeRepositoryInterface
{
    private EventDispatcher $eventDispatcher;

    private array $events = [];

    private Projector $projector;

    public function __construct(EventDispatcher $eventDispatcher, Projector $projector)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->projector       = $projector;
    }

    public function apply(Employee $aggregateRoot): void
    {
        $this->events = array_merge($this->events, $aggregateRoot->getUncommittedEvents());
    }

    public function get(AggregateRootId $aggregateRootId): AggregateRoot
    {
        return null;
    }

    public function save(): void
    {
        foreach ($this->events as $event)
        {
            $this->projector->project($event);
            $this->eventDispatcher->dispatch($event);
        }
    }
}