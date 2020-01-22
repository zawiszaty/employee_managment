<?php

declare(strict_types=1);

namespace App\module\Employee\tests\Application\Command\GenerateRaport\Salary\GenerateSalaryReport;

use App\Infrastructure\Infrastructure\InMemoryEventDispatcher;
use App\module\Employee\Application\EmployeeApi;
use App\module\Employee\Application\Command\GenerateRaport\Salary\GenerateSalaryReport\GenerateSalaryReportForSingleEmployeeCommand;
use App\module\Employee\Application\Command\GenerateRaport\Salary\GenerateSalaryReport\GenerateSalaryReportForSingleEmployeeHandler;
use App\module\Employee\Domain\Employee;
use App\module\Employee\Domain\Entity\WorkedDay;
use App\module\Employee\Domain\Event\EmployeeSalaryReportGeneratedEvent;
use App\module\Employee\Domain\Policy\CalculateRewardPolicy\CalculateRewardPolicyFactory;
use App\module\Employee\Infrastructure\Repository\InMemoryEmployeeAggregateRepository;
use App\module\Employee\tests\TestDouble\EmployeeMother;
use PHPUnit\Framework\TestCase;

class GenerateSalaryReportForSingleEmployeeHandlerTest extends TestCase
{
    private InMemoryEmployeeAggregateRepository $repository;

    private Employee $employee;

    private InMemoryEventDispatcher $eventDispatcher;

    private EmployeeApi $api;

    protected function setUp(): void
    {
        $this->eventDispatcher = new InMemoryEventDispatcher();
        $this->repository = new InMemoryEmployeeAggregateRepository($this->eventDispatcher);
        $handler = new GenerateSalaryReportForSingleEmployeeHandler($this->repository, new CalculateRewardPolicyFactory());
        $this->employee = EmployeeMother::createEmployeeM();

        for ($i = 0; $i < 20; ++$i) {
            $this->employee->workedDay(WorkedDay::create(8));
        }
        $this->repository->apply($this->employee);
        $this->repository->save();
        $this->eventDispatcher->popEvents();
        $this->api = new EmployeeApi();
        $this->api->addHandler($handler);
    }

    public function testItGenerateReport(): void
    {
        $this->api->handle(new GenerateSalaryReportForSingleEmployeeCommand($this->employee->getId()->toString(), 1));
        $events = $this->eventDispatcher->getEvents();
        $this->assertCount(1, $events);
        $this->assertInstanceOf(EmployeeSalaryReportGeneratedEvent::class, $events[0]);
    }
}
