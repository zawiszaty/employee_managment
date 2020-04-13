<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\Application\Command\EmployeeSaleProduct;

use App\Infrastructure\Infrastructure\FakeEventDispatcher;
use App\Module\Employee\Application\Command\EmployeeSaleProduct\EmployeeSaleProductCommand;
use App\Module\Employee\Application\Command\EmployeeSaleProduct\EmployeeSaleProductHandler;
use App\Module\Employee\Application\EmployeeApi;
use App\Module\Employee\Domain\Employee;
use App\Module\Employee\Domain\Event\EmployeeWasSaleItemEvent;
use App\Module\Employee\Domain\ValueObject\PersonalData;
use App\Module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\Module\Employee\Domain\ValueObject\Salary;
use App\Module\Employee\Infrastructure\Repository\InMemoryEmployeeAggregateRepository;
use PHPUnit\Framework\TestCase;

final class EmployeeSaleProductHandlerTest extends TestCase
{
    private FakeEventDispatcher $eventDispatcher;

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
        $this->eventDispatcher = new FakeEventDispatcher();
        $this->repo = new InMemoryEmployeeAggregateRepository();
        $employeeSaleProductHandler = new EmployeeSaleProductHandler($this->repo, $this->eventDispatcher);
        $this->api = new EmployeeApi();
        $this->api->addHandler($employeeSaleProductHandler);
    }
}
