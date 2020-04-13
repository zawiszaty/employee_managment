<?php

declare(strict_types=1);

namespace App\Infrastructure\tests\Infrastructure;

use App\Infrastructure\Infrastructure\EventDispatcher;
use PHPStan\Testing\TestCase;

class Event implements \App\Infrastructure\Domain\Event
{
    public function toArray(): array
    {
        return [];
    }

    public static function fromArray(array $payload): \App\Infrastructure\Domain\Event
    {
        return new static();
    }
}

class EventPublisher implements \App\Infrastructure\Domain\EventPublisher
{
    private int $counter = 0;

    public function dispatch(\App\Infrastructure\Domain\Event $event): void
    {
        ++$this->counter;
    }

    public function supports(\App\Infrastructure\Domain\Event $event): bool
    {
        return Event::class === get_class($event);
    }

    public function getCounter(): int
    {
        return $this->counter;
    }
}

final class EventDispatcherTest extends TestCase
{
    private EventDispatcher $dispatcher;

    private EventPublisher $publisher;

    protected function setUp(): void
    {
        $this->dispatcher = new EventDispatcher();
        $this->publisher = new EventPublisher();
        $this->dispatcher->addEventPublisher($this->publisher);
    }

    public function testItDispatchEvent(): void
    {
        $this->dispatcher->dispatch(new Event());
        $this->assertSame(1, $this->publisher->getCounter());
    }
}
