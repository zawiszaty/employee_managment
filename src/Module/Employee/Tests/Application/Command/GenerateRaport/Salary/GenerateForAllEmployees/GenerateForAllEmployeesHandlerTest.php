<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\Application\Command\GenerateReport\Salary\GenerateForAllEmployees;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\Clock;
use App\Infrastructure\Domain\Clock\FixedClock;
use App\Infrastructure\Infrastructure\FakeEventDispatcher;
use App\Module\Employee\Application\Command\GenerateReport\Salary\GenerateForAllEmployees\GenerateForAllEmployeesCommand;
use App\Module\Employee\Application\Command\GenerateReport\Salary\GenerateForAllEmployees\GenerateForAllEmployeesHandler;
use App\Module\Employee\Application\EmployeeApi;
use App\Module\Employee\Domain\Entity\SalaryReport;
use App\Module\Employee\Domain\Entity\SalaryReportType;
use App\Module\Employee\Domain\Event\EmployeeSalaryReportForAllEmployeesGeneratedEvent;
use App\Module\Employee\Domain\ValueObject\Reward;
use App\Module\Employee\Infrastructure\Repository\InMemorySalaryReportRepository;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class GenerateForAllEmployeesHandlerTest extends TestCase
{
    private FakeEventDispatcher $eventDispatcher;

    private InMemorySalaryReportRepository $repository;

    private EmployeeApi $api;

    protected function setUp(): void
    {
        $this->eventDispatcher = new FakeEventDispatcher();
        $this->repository = new InMemorySalaryReportRepository();
        $handler = new GenerateForAllEmployeesHandler($this->repository, $this->eventDispatcher);

        for ($i = 0; $i < 10; ++$i) {
            $this->repository->apply(SalaryReport::create(AggregateRootId::generate(), Reward::createFromFloat(20.0), FixedClock::fixed(new DateTimeImmutable('1-01-2020')), 10, SalaryReportType::SINGLE_EMPLOYEE()));
        }

        $this->api = new EmployeeApi();
        $this->api->addHandler($handler);
    }

    public function testItGenerateReportForAllEmployee(): void
    {
        $this->api->handle(new GenerateForAllEmployeesCommand(Clock::fixed(new DateTimeImmutable('1-01-2020'))));
        /** @var EmployeeSalaryReportForAllEmployeesGeneratedEvent $event */
        $event = $this->eventDispatcher->getEvents()[0];

        $this->assertInstanceOf(EmployeeSalaryReportForAllEmployeesGeneratedEvent::class, $event);
        $this->assertSame(200.0, $event->getReward()->getAmount());
        $this->assertSame(01, (int) $event->getMonth()->currentDateTime()->format('m'));
        $this->assertSame(100, $event->getHoursAmount());
        $this->assertSame(10, $event->getEmployeeAmounts());
    }
}
