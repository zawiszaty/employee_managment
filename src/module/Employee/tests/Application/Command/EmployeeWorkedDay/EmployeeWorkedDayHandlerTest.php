<?php

declare(strict_types=1);

namespace App\module\Employee\tests\Application\Command\EmployeeWorkedDay;

use App\Infrastructure\Infrastructure\InMemoryEventDispatcher;
use App\module\Employee\Application\Command\EmployeeWorkedDay\EmployeeWorkedDayCommand;
use App\module\Employee\Application\Command\EmployeeWorkedDay\EmployeeWorkedDayHandler;
use App\module\Employee\Application\EmployeeApi;
use App\module\Employee\Domain\Event\EmployeeWasWorkedDayEvent;
use App\module\Employee\Infrastructure\Repository\InMemoryEmployeeAggregateRepository;
use App\module\Employee\tests\TestDouble\EmployeeMother;
use PHPUnit\Framework\TestCase;

/**
 * @codeCoverageIgnore
 */
final class EmployeeWorkedDayHandlerTest extends TestCase
{
    private InMemoryEventDispatcher $eventDispatcher;

    private InMemoryEmployeeAggregateRepository $repo;

    private EmployeeApi $api;

    public function testItEmployeeSaleItem(): void
    {
        $employee = EmployeeMother::createEmployeeM();
        $this->repo->apply($employee);
        $this->api->handle(new EmployeeWorkedDayCommand($employee->getId()->toString(), 8));
        $events = $this->eventDispatcher->getEvents();
        $this->assertCount(2, $events);
        /** @var EmployeeWasWorkedDayEvent $event */
        $event = $events[1];
        $this->assertInstanceOf(EmployeeWasWorkedDayEvent::class, $event);
        $this->assertSame(8, $event->getWorkedDay()->getHoursAmount());
    }

    protected function setUp(): void
    {
        $this->eventDispatcher = new InMemoryEventDispatcher();
        $this->repo = new InMemoryEmployeeAggregateRepository($this->eventDispatcher);
        $employeeWorkedDayHandler = new EmployeeWorkedDayHandler($this->repo);
        $this->api = new EmployeeApi();
        $this->api->addHandler($employeeWorkedDayHandler);
    }
}
