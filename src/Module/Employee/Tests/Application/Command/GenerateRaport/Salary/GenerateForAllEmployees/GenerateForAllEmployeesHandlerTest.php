<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\Application\Command\GenerateReport\Salary\GenerateForAllEmployees;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\Clock;
use App\Infrastructure\Domain\Clock\FixedClock;
use App\Infrastructure\Domain\Uuid;
use App\Infrastructure\Infrastructure\FakeEventDispatcher;
use App\Module\Employee\Application\Command\GenerateReport\Salary\GenerateForAllEmployees\GenerateForAllEmployeesCommand;
use App\Module\Employee\Application\Command\GenerateReport\Salary\GenerateForAllEmployees\GenerateForAllEmployeesHandler;
use App\Module\Employee\Application\EmployeeApi;
use App\Module\Employee\Domain\Entity\SalaryReport;
use App\Module\Employee\Domain\Entity\SalaryReportType;
use App\Module\Employee\Domain\Event\EmployeeSalaryReportForAllEmployeesGeneratedEvent;
use App\Module\Employee\Domain\ValueObject\Path;
use App\Module\Employee\Domain\ValueObject\Reward;
use App\Module\Employee\Infrastructure\Repository\InMemorySalaryReportRepository;
use App\Module\Employee\Tests\TestDouble\SpyPDFGenerator;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class GenerateForAllEmployeesHandlerTest extends TestCase
{
    private FakeEventDispatcher $eventDispatcher;

    private InMemorySalaryReportRepository $repository;

    private EmployeeApi $api;

    private SpyPDFGenerator $PDFGenerator;

    protected function setUp(): void
    {
        $this->eventDispatcher = new FakeEventDispatcher();
        $this->repository      = new InMemorySalaryReportRepository();
        $this->PDFGenerator    = new SpyPDFGenerator();
        $handler               = new GenerateForAllEmployeesHandler($this->repository, $this->eventDispatcher, $this->PDFGenerator);

        for ($i = 0; $i < 10; ++$i)
        {
            $this->repository->apply(
                SalaryReport::create(
                    Uuid::generate(),
                    AggregateRootId::generate(),
                    Reward::createFromFloat(20.0),
                    FixedClock::fixed(new DateTimeImmutable('1-01-2020')),
                    10,
                    SalaryReportType::SINGLE_EMPLOYEE(),
                    Path::generate('test', 'pdf')
                )
            );
        }

        $this->api = new EmployeeApi();
        $this->api->addHandler($handler);
    }

    public function testItGenerateReportForAllEmployee(): void
    {
        $this->api->handle(new GenerateForAllEmployeesCommand(Clock::fixed(new DateTimeImmutable('1-01-2020'))));

        $event = $this->eventDispatcher->getEvents()[0];
        $this->assertInstanceOf(EmployeeSalaryReportForAllEmployeesGeneratedEvent::class, $event);
        /** @var EmployeeSalaryReportForAllEmployeesGeneratedEvent $event */
        $this->assertSame(200.0, $event->getReward()->getAmount());
        $this->assertSame(01, (int) $event->getMonth()->currentDateTime()->format('m'));
        $this->assertSame(100, $event->getHoursAmount());
        $this->assertSame(10, $event->getEmployeeAmounts());
        $this->assertSame(1, $this->PDFGenerator->getCounter());
    }
}
