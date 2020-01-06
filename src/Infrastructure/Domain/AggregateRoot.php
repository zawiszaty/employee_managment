<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain;

/**
 * @method AggregateRootId getId()
 */
abstract class AggregateRoot
{
    /** @var array<Event> */
    private array $events;

    public function record(Event $event): void
    {
        $this->events[] = $event;
    }

    public function commitEvents(): void
    {
        $this->events = [];
    }

    /**
     * @return array<Event>
     */
    public function getUncommittedEvents(): array
    {
        return $this->events;
    }
}
