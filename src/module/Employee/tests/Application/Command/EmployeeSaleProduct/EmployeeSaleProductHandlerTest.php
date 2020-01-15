<?php

declare(strict_types=1);

namespace App\module\Employee\tests\Application\Command\EmployeeSaleProduct;

use App\Infrastructure\Infrastructure\InMemoryEventDispatcher;
use App\module\Employee\Application\Command\EmployeeSaleProduct\EmployeeSaleProductCommand;
use App\module\Employee\Application\Command\EmployeeSaleProduct\EmployeeSaleProductHandler;
use App\module\Employee\Domain\Employee;
use App\module\Employee\Domain\Event\EmployeeWasSaleItemEvent;
use App\module\Employee\Domain\ValueObject\PersonalData;
use App\module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\module\Employee\Domain\ValueObject\Salary;
use App\module\Employee\Infrastructure\Repository\InMemoryEmployeeRepository;
use PHPUnit\Framework\TestCase;

/**
 * @codeCoverageIgnore
 */
final class EmployeeSaleProductHandlerTest extends TestCase
{
    private InMemoryEventDispatcher $eventDispatcher;

    private EmployeeSaleProductHandler $employeeSaleProductHandler;

    private InMemoryEmployeeRepository $repo;

    public function testItEmployeeSaleItem(): void
    {
        $employee = Employee::create(
            PersonalData::createFromString('test', 'test', 'test'),
            RemunerationCalculationWay::MONTHLY_WITH_COMMISSION(),
            Salary::createFromFloat(2.5),
        );
        $this->repo->apply($employee);
        $this->employeeSaleProductHandler->handle(new EmployeeSaleProductCommand($employee->getId()->toString(), 200));
        $events = $this->eventDispatcher->getEvents();
        $this->assertCount(2, $events);
        $this->assertInstanceOf(EmployeeWasSaleItemEvent::class, $events[1]);
    }

    protected function setUp(): void
    {
        $this->eventDispatcher = new InMemoryEventDispatcher();
        $this->repo = new InMemoryEmployeeRepository($this->eventDispatcher);
        $this->employeeSaleProductHandler = new EmployeeSaleProductHandler($this->repo);
    }
}
