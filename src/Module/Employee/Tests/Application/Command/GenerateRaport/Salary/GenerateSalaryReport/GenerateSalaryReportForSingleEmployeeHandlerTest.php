<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\Application\Command\GenerateReport\Salary\GenerateSalaryReport;

use App\Infrastructure\Domain\Clock;
use App\Infrastructure\Infrastructure\FakeEventDispatcher;
use App\Module\Employee\Application\Command\GenerateReport\Salary\GenerateSalaryReport\GenerateSalaryReportForSingleEmployeeCommand;
use App\Module\Employee\Application\Command\GenerateReport\Salary\GenerateSalaryReport\GenerateSalaryReportForSingleEmployeeHandler;
use App\Module\Employee\Application\EmployeeApi;
use App\Module\Employee\Domain\Employee;
use App\Module\Employee\Domain\Entity\WorkedDay;
use App\Module\Employee\Domain\Event\EmployeeSalaryReportGeneratedEvent;
use App\Module\Employee\Domain\Policy\CalculateRewardPolicy\CalculateRewardPolicyFactory;
use App\Module\Employee\Infrastructure\Repository\InMemoryEmployeeAggregateRepository;
use App\Module\Employee\Tests\TestDouble\EmployeeMother;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class GenerateSalaryReportForSingleEmployeeHandlerTest extends TestCase
{
    private InMemoryEmployeeAggregateRepository $repository;

    private Employee $employee;

    private FakeEventDispatcher $eventDispatcher;

    private EmployeeApi $api;

    protected function setUp(): void
    {
        $this->eventDispatcher = new FakeEventDispatcher();
        $this->repository = new InMemoryEmployeeAggregateRepository($this->eventDispatcher);
        $handler = new GenerateSalaryReportForSingleEmployeeHandler($this->repository, new CalculateRewardPolicyFactory());
        $this->employee = EmployeeMother::createEmployeeM();

        for ($i = 0; $i < 20; ++$i) {
            $this->employee->workedDay(WorkedDay::create(8, Clock::system()));
        }
        $this->repository->apply($this->employee);
        $this->repository->save();
        $this->eventDispatcher->popEvents();
        $this->api = new EmployeeApi();
        $this->api->addHandler($handler);
    }

    public function testItGenerateReport(): void
    {
        $this->api->handle(new GenerateSalaryReportForSingleEmployeeCommand($this->employee->getId()
            ->toString(), new DateTimeImmutable('1-01-2020')));
        $events = $this->eventDispatcher->getEvents();
        $this->assertCount(1, $events);
        $this->assertInstanceOf(EmployeeSalaryReportGeneratedEvent::class, $events[0]);
    }
}
