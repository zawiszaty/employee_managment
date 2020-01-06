<?php

declare(strict_types=1);

namespace App\module\Employee\tests\Application;

use App\Infrastructure\Infrastructure\InMemoryEventDispatcher;
use App\module\Employee\Application\CreateEmployeeService;
use App\module\Employee\Domain\Event\EmployeeWasCreatedEvent;
use App\module\Employee\Infrastructure\Repository\InMemoryEmployeeRepository;
use PHPUnit\Framework\TestCase;

/**
 * @codeCoverageIgnore
 */
final class CreateEmployeeServiceTest extends TestCase
{
    private InMemoryEventDispatcher $eventDispatcher;

    private CreateEmployeeService $createEmployeeService;

    public function testItCreateEmployee(): void
    {
        $this->createEmployeeService->create('test', 'test', 'test', 'hourly', 2.5);
        $events = $this->eventDispatcher->getEvents();
        $this->assertCount(1, $events);
        $this->assertInstanceOf(EmployeeWasCreatedEvent::class, $events[0]);
    }

    protected function setUp(): void
    {
        $this->eventDispatcher = new InMemoryEventDispatcher();
        $this->createEmployeeService = new CreateEmployeeService(new InMemoryEmployeeRepository($this->eventDispatcher));
    }
}
