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
use App\Module\Employee\Infrastructure\Generator\DummyPDFGenerator;
use App\Module\Employee\Infrastructure\Repository\InMemoryEmployeeAggregateRepository;
use App\Module\Employee\Infrastructure\Repository\InMemoryWorkedDayReportRepository;
use App\Module\Employee\Tests\TestDouble\EmployeeMother;
use App\Module\Employee\Tests\TestDouble\SpyPDFGenerator;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class GenerateSalaryReportForSingleEmployeeHandlerTest extends TestCase
{
    private InMemoryEmployeeAggregateRepository $repository;

    private Employee $employee;

    private FakeEventDispatcher $eventDispatcher;

    private EmployeeApi $api;

    private InMemoryWorkedDayReportRepository $inMemoryWorkedDayReportRepository;

    private SpyPDFGenerator $PDFGenerator;

    protected function setUp(): void
    {
        $this->eventDispatcher                   = new FakeEventDispatcher();
        $this->repository                        = new InMemoryEmployeeAggregateRepository();
        $this->inMemoryWorkedDayReportRepository = new InMemoryWorkedDayReportRepository;
        $this->employee                          = EmployeeMother::createEmployeeM();
        $this->PDFGenerator                      = new SpyPDFGenerator();
        $handler                                 = new GenerateSalaryReportForSingleEmployeeHandler(
            $this->repository,
            new CalculateRewardPolicyFactory(),
            $this->eventDispatcher,
            $this->PDFGenerator,
            $this->inMemoryWorkedDayReportRepository
        );

        for ($i = 0; $i < 20; ++$i)
        {
            $this->inMemoryWorkedDayReportRepository->apply(WorkedDay::create(8, Clock::system(), $this->employee->getId()));
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
        $this->assertCount(2, $events);
        $event = $events[1];
        $this->assertInstanceOf(EmployeeSalaryReportGeneratedEvent::class, $event);
        /** @var EmployeeSalaryReportGeneratedEvent $event */
        $this->assertSame($this->employee->getId()->toString(), $event->getAggregateId()->toString());
        $salaryReport = $event->getSalaryReport();
        $this->assertSame(160, $salaryReport->getHoursAmount());
        $this->assertSame('01', $salaryReport->getMonth()->currentDateTime()
            ->format('m'));
        $this->assertSame(1, $this->PDFGenerator->getCounter());
    }
}
