<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\Infrastructure\Projection;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\Clock;
use App\Infrastructure\Domain\EventId;
use App\Module\Employee\Domain\Entity\SalaryReport;
use App\Module\Employee\Domain\Entity\SalaryReportType;
use App\Module\Employee\Domain\Entity\WorkedDay;
use App\Module\Employee\Domain\Event\EmployeeSalaryReportForAllEmployeesGeneratedEvent;
use App\Module\Employee\Domain\Event\EmployeeSalaryReportGeneratedEvent;
use App\Module\Employee\Domain\Event\EmployeeWasCreatedEvent;
use App\Module\Employee\Domain\Event\EmployeeWasSaleItemEvent;
use App\Module\Employee\Domain\Event\EmployeeWasWorkedDayEvent;
use App\Module\Employee\Domain\ValueObject\Commission;
use App\Module\Employee\Domain\ValueObject\PersonalData;
use App\Module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\Module\Employee\Domain\ValueObject\Reward;
use App\Module\Employee\Domain\ValueObject\Salary;
use App\Module\Employee\Infrastructure\Projection\EmployeeProjection;
use App\Module\Employee\Infrastructure\ReadModel\View\EmployeeView;
use App\Module\Employee\Infrastructure\ReadModel\View\SalaryReportView;
use App\Module\Employee\Infrastructure\ReadModel\View\WorkedDayView;
use App\Module\Employee\Tests\Infrastructure\InfrastructureTestCase;
use App\Module\Employee\Tests\Infrastructure\Traits\CreateEmployeeTrait;
use DateTimeImmutable;

final class EmployeeProjectionTest extends InfrastructureTestCase
{
    use CreateEmployeeTrait;

    private EmployeeProjection $projection;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository|\Doctrine\Persistence\ObjectRepository
     */
    private $employeeRepository;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository|\Doctrine\Persistence\ObjectRepository
     */
    private $workedDayRepository;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository|\Doctrine\Persistence\ObjectRepository
     */
    private $salaryReportRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->projection = self::$container->get(EmployeeProjection::class);
        $this->employeeRepository = $this->entityManager->getRepository(EmployeeView::class);
        $this->workedDayRepository = $this->entityManager->getRepository(WorkedDayView::class);
        $this->salaryReportRepository = $this->entityManager->getRepository(SalaryReportView::class);
    }

    public function testItCreateEmployeeInDB(): void
    {
        self::assertCount(0, $this->employeeRepository->findAll());
        $this->projection->handleEmployeeWasCreatedEvent(
            new EmployeeWasCreatedEvent(
                AggregateRootId::generate(),
                PersonalData::createFromString('test', 'test', 'test'),
                RemunerationCalculationWay::HOURLY(),
                Salary::createFromFloat(20.0),
            )
        );

        /** @var EmployeeView $employee */
        $employee = $this->employeeRepository->findOneBy([]);

        self::assertNotNull($employee);
        $this->assertSame('test', $employee->getAddress());
        $this->assertSame('test', $employee->getFirstName());
        $this->assertSame('test', $employee->getLastName());
        $this->assertTrue($employee->getRemunerationCalculationWay()->equals(RemunerationCalculationWay::HOURLY()));
        $this->assertSame(20.0, $employee->getSalary());
    }

    public function testItSaveCommisionsWhenEmployeeSaleProduct(): void
    {
        $employee = $this->createEmployee(RemunerationCalculationWay::MONTHLY_WITH_COMMISSION());
        $this->entityManager->persist($employee);
        $this->entityManager->flush();

        $this->projection->handleEmployeeWasSaleItemEvent(new EmployeeWasSaleItemEvent(
            EventId::generate(),
            AggregateRootId::fromString($employee->getId()->toString()),
            Commission::createFromFloat(100.0)
        ));
        /** @var EmployeeView $employee */
        $employee = $this->employeeRepository->find($employee->getId());

        $this->assertSame(100.0, $employee->getCommissions());
    }

    public function testItSaveEmployeeWorkedDayInfo(): void
    {
        $employee = $this->createEmployee(RemunerationCalculationWay::MONTHLY());
        $this->entityManager->persist($employee);
        $this->entityManager->flush();

        $this->projection->handleEmployeeWasWorkedDayEvent(new EmployeeWasWorkedDayEvent(
            EventId::generate(),
            AggregateRootId::fromString($employee->getId()->toString()),
            WorkedDay::create(8, Clock::fixed(new DateTimeImmutable('01-02-2020')))
        ));
        /** @var WorkedDayView $workedDayView */
        $workedDayView = $this->workedDayRepository->findOneBy([]);

        $this->assertNotNull($workedDayView);
        $this->assertSame(8, $workedDayView->getHoursAmount());
        $this->assertSame((new DateTimeImmutable('01-02-2020'))->getTimestamp(), $workedDayView->getDay()
            ->getTimestamp());
    }

    public function testItSaveEmployeeSalaryReport(): void
    {
        $employee = $this->createEmployee(RemunerationCalculationWay::MONTHLY());
        $this->entityManager->persist($employee);
        $this->entityManager->flush();

        $this->projection->handleEmployeeSalaryReportGeneratedEvent(new EmployeeSalaryReportGeneratedEvent(
            EventId::generate(),
            AggregateRootId::fromString($employee->getId()->toString()),
            SalaryReport::create(AggregateRootId::fromString($employee->getId()
                ->toString()), Reward::createFromFloat(200.0), Clock::fixed(new DateTimeImmutable('01-01-2020')), 20, SalaryReportType::SINGLE_EMPLOYEE())
        ));
        /** @var SalaryReportView $salaryReportView */
        $salaryReportView = $this->salaryReportRepository->findOneBy([]);

        $this->assertNotNull($salaryReportView);
        $this->assertTrue($salaryReportView->getType()->equals(SalaryReportType::SINGLE_EMPLOYEE()));
    }

    public function testItSaveEmployeesSalaryReport(): void
    {
        $employee = $this->createEmployee(RemunerationCalculationWay::MONTHLY());
        $this->entityManager->persist($employee);
        $this->entityManager->flush();

        $this->projection->handleEmployeeSalaryReportForAllEmployeesGeneratedEvent(new EmployeeSalaryReportForAllEmployeesGeneratedEvent(
            Reward::createFromFloat(200.0),
            Clock::fixed(new DateTimeImmutable('01-01-2020')),
            10,
            10
        ));
        /** @var SalaryReportView $salaryReportView */
        $salaryReportView = $this->salaryReportRepository->findOneBy([]);

        $this->assertNotNull($salaryReportView);
        $this->assertTrue($salaryReportView->getType()->equals(SalaryReportType::ALL_EMPLOYEE()));
    }
}
