<?php

declare(strict_types=1);

namespace App\module\Employee\tests\Application\Command\GenerateRaport\Salary\GenerateForAllEmployees;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Infrastructure\InMemoryEventDispatcher;
use App\module\Employee\Application\Command\GenerateRaport\Salary\GenerateForAllEmployees\GenerateForAllEmployeesCommand;
use App\module\Employee\Application\Command\GenerateRaport\Salary\GenerateForAllEmployees\GenerateForAllEmployeesHandler;
use App\module\Employee\Application\EmployeeApi;
use App\module\Employee\Domain\Entity\SalaryReport;
use App\module\Employee\Domain\Event\EmployeeSalaryReportForAllEmployeesGeneratedEvent;
use App\module\Employee\Domain\ValueObject\Reward;
use App\module\Employee\Infrastructure\Repository\InMemorySalaryReportRepository;
use PHPUnit\Framework\TestCase;

final class GenerateForAllEmployeesHandlerTest extends TestCase
{
    private InMemoryEventDispatcher $eventDispatcher;

    private InMemorySalaryReportRepository $repository;

    private EmployeeApi $api;

    protected function setUp(): void
    {
        $this->eventDispatcher = new InMemoryEventDispatcher();
        $this->repository = new InMemorySalaryReportRepository();
        $handler = new GenerateForAllEmployeesHandler($this->repository, $this->eventDispatcher);

        for ($i = 0; $i < 10; ++$i) {
            $this->repository->apply(SalaryReport::create(AggregateRootId::generate(), Reward::createFromFloat(20.0), 01, 10));
        }

        $this->api = new EmployeeApi();
        $this->api->addHandler($handler);
    }

    public function testItGenerateReportForAllEmployee(): void
    {
        $this->api->handle(new GenerateForAllEmployeesCommand(01));
        /** @var EmployeeSalaryReportForAllEmployeesGeneratedEvent $event */
        $event = $this->eventDispatcher->getEvents()[0];

        $this->assertInstanceOf(EmployeeSalaryReportForAllEmployeesGeneratedEvent::class, $event);
        $this->assertSame(200.0, $event->getReward()->getAmount());
        $this->assertSame(01, $event->getMonth());
        $this->assertSame(100, $event->getHoursAmount());
        $this->assertSame(10, $event->getEmployeeAmounts());
    }
}
