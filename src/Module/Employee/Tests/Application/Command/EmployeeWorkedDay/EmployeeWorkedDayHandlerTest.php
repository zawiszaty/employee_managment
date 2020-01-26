<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\Application\Command\EmployeeWorkedDay;

use App\Infrastructure\Infrastructure\FakeEventDispatcher;
use App\Module\Employee\Application\Command\EmployeeWorkedDay\EmployeeWorkedDayCommand;
use App\Module\Employee\Application\Command\EmployeeWorkedDay\EmployeeWorkedDayHandler;
use App\Module\Employee\Application\EmployeeApi;
use App\Module\Employee\Domain\Event\EmployeeWasWorkedDayEvent;
use App\Module\Employee\Infrastructure\Repository\InMemoryEmployeeAggregateRepository;
use App\Module\Employee\Tests\TestDouble\EmployeeMother;
use PHPUnit\Framework\TestCase;

/**
 * @codeCoverageIgnore
 */
final class EmployeeWorkedDayHandlerTest extends TestCase
{
    private FakeEventDispatcher $eventDispatcher;

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
        $this->eventDispatcher = new FakeEventDispatcher();
        $this->repo = new InMemoryEmployeeAggregateRepository($this->eventDispatcher);
        $employeeWorkedDayHandler = new EmployeeWorkedDayHandler($this->repo);
        $this->api = new EmployeeApi();
        $this->api->addHandler($employeeWorkedDayHandler);
    }
}
