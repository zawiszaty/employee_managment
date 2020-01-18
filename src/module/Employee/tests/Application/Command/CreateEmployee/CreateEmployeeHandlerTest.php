<?php

declare(strict_types=1);

namespace App\module\Employee\tests\Application\Command\CreateEmployee;

use App\Infrastructure\Infrastructure\InMemoryEventDispatcher;
use App\module\Employee\Application\Command\CreateEmployee\CreateEmployeeCommand;
use App\module\Employee\Application\Command\CreateEmployee\CreateEmployeeHandler;
use App\module\Employee\Domain\Event\EmployeeWasCreatedEvent;
use App\module\Employee\Infrastructure\Repository\InMemoryEmployeeAggregateRepository;
use PHPUnit\Framework\TestCase;

/**
 * @codeCoverageIgnore
 */
final class CreateEmployeeHandlerTest extends TestCase
{
    private InMemoryEventDispatcher $eventDispatcher;

    private CreateEmployeeHandler $createEmployeeHandler;

    public function testItCreateEmployee(): void
    {
        $this->createEmployeeHandler->handle(new CreateEmployeeCommand('test', 'test', 'test', 'hourly', 2.5));
        $events = $this->eventDispatcher->getEvents();
        $this->assertCount(1, $events);
        $this->assertInstanceOf(EmployeeWasCreatedEvent::class, $events[0]);
    }

    protected function setUp(): void
    {
        $this->eventDispatcher = new InMemoryEventDispatcher();
        $this->createEmployeeHandler = new CreateEmployeeHandler(new InMemoryEmployeeAggregateRepository($this->eventDispatcher));
    }
}
