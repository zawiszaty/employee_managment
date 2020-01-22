<?php

declare(strict_types=1);

namespace App\module\Employee\tests\Application\Command\EmployeeWorkedDay;

use App\Infrastructure\Infrastructure\InMemoryEventDispatcher;
use App\module\Employee\Application\EmployeeApi;
use App\module\Employee\Application\Command\EmployeeWorkedDay\EmployeeWorkedDayCommand;
use App\module\Employee\Application\Command\EmployeeWorkedDay\EmployeeWorkedDayHandler;
use App\module\Employee\Domain\Employee;
use App\module\Employee\Domain\Event\EmployeeWasWorkedDayEvent;
use App\module\Employee\Domain\ValueObject\PersonalData;
use App\module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\module\Employee\Domain\ValueObject\Salary;
use App\module\Employee\Infrastructure\Repository\InMemoryEmployeeAggregateRepository;
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
        $employee = Employee::create(
            PersonalData::createFromString('test', 'test', 'test'),
            RemunerationCalculationWay::MONTHLY_WITH_COMMISSION(),
            Salary::createFromFloat(2.5),
        );
        $this->repo->apply($employee);
        $this->api->handle(new EmployeeWorkedDayCommand($employee->getId()->toString(), 8));
        $events = $this->eventDispatcher->getEvents();
        $this->assertCount(2, $events);
        $this->assertInstanceOf(EmployeeWasWorkedDayEvent::class, $events[1]);
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
