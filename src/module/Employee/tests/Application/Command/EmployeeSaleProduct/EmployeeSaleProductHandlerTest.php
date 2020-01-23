<?php

declare(strict_types=1);

namespace App\module\Employee\tests\Application\Command\EmployeeSaleProduct;

use App\Infrastructure\Infrastructure\InMemoryEventDispatcher;
use App\module\Employee\Application\Command\EmployeeSaleProduct\EmployeeSaleProductCommand;
use App\module\Employee\Application\Command\EmployeeSaleProduct\EmployeeSaleProductHandler;
use App\module\Employee\Application\EmployeeApi;
use App\module\Employee\Domain\Employee;
use App\module\Employee\Domain\Event\EmployeeWasSaleItemEvent;
use App\module\Employee\Domain\ValueObject\PersonalData;
use App\module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\module\Employee\Domain\ValueObject\Salary;
use App\module\Employee\Infrastructure\Repository\InMemoryEmployeeAggregateRepository;
use PHPUnit\Framework\TestCase;

/**
 * @codeCoverageIgnore
 */
final class EmployeeSaleProductHandlerTest extends TestCase
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
        $this->api->handle(new EmployeeSaleProductCommand($employee->getId()->toString(), 200));
        $events = $this->eventDispatcher->getEvents();
        $this->assertCount(2, $events);
        /** @var EmployeeWasSaleItemEvent $event */
        $event = $events[1];
        $this->assertInstanceOf(EmployeeWasSaleItemEvent::class, $event);
        $this->assertSame(200.0, $event->getCommission()->getCommission());
    }

    protected function setUp(): void
    {
        $this->eventDispatcher = new InMemoryEventDispatcher();
        $this->repo = new InMemoryEmployeeAggregateRepository($this->eventDispatcher);
        $employeeSaleProductHandler = new EmployeeSaleProductHandler($this->repo);
        $this->api = new EmployeeApi();
        $this->api->addHandler($employeeSaleProductHandler);
    }
}
