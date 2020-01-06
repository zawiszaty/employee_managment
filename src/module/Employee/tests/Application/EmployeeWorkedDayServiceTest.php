<?php

declare(strict_types=1);

namespace App\module\Employee\tests\Application;

use App\Infrastructure\Infrastructure\InMemoryEventDispatcher;
use App\module\Employee\Application\EmployeeWorkedDayService;
use App\module\Employee\Domain\Employee;
use App\module\Employee\Domain\Event\EmployeeWasWorkedDayEvent;
use App\module\Employee\Domain\ValueObject\PersonalData;
use App\module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\module\Employee\Domain\ValueObject\Salary;
use App\module\Employee\Infrastructure\Repository\InMemoryEmployeeRepository;
use PHPUnit\Framework\TestCase;

/**
 * @codeCoverageIgnore
 */
final class EmployeeWorkedDayServiceTest extends TestCase
{
    private InMemoryEventDispatcher $eventDispatcher;

    private EmployeeWorkedDayService $employeeSaleProductService;

    private InMemoryEmployeeRepository $repo;

    public function testItEmployeeSaleItem(): void
    {
        $employee = Employee::create(
            PersonalData::createFromString('test', 'test', 'test'),
            RemunerationCalculationWay::MONTHLY_WITH_COMMISSION(),
            Salary::createFromFloat(2.5),
        );
        $this->repo->apply($employee);
        $this->employeeSaleProductService->workedDay($employee->getId()->toString(), 8);
        $events = $this->eventDispatcher->getEvents();
        $this->assertCount(2, $events);
        $this->assertInstanceOf(EmployeeWasWorkedDayEvent::class, $events[1]);
    }

    protected function setUp(): void
    {
        $this->eventDispatcher = new InMemoryEventDispatcher();
        $this->repo = new InMemoryEmployeeRepository($this->eventDispatcher);
        $this->employeeSaleProductService = new EmployeeWorkedDayService($this->repo);
    }
}
