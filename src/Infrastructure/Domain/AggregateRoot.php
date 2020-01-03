<?php

declare(strict_types=1);


namespace App\Infrastructure\Domain;


abstract class AggregateRoot
{
    private array $events;

    public function record(Event $event): void
    {
        $this->events[] = $event;
    }

    public function commitEvents(): void
    {
        $this->events = [];
    }

    public function getUncommittedEvents(): array
    {
        return $this->events;
    }
}