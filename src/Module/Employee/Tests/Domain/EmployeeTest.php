<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\Domain;

use App\Infrastructure\Domain\Clock;
use App\Module\Employee\Domain\Entity\WorkedDay;
use App\Module\Employee\Domain\Event\EmployeeSalaryReportGeneratedEvent;
use App\Module\Employee\Domain\Event\EmployeeWasCreatedEvent;
use App\Module\Employee\Domain\Event\EmployeeWasSaleItemEvent;
use App\Module\Employee\Domain\Event\EmployeeWasWorkedDayEvent;
use App\Module\Employee\Domain\Policy\CalculateRewardPolicy\CalculateHourlyRewardPolicy;
use App\Module\Employee\Domain\Policy\CalculateRewardPolicy\CalculateMonthlyRewardPolicy;
use App\Module\Employee\Domain\Policy\CalculateRewardPolicy\CalculateMonthlyWithCommissionRewardPolicy;
use App\Module\Employee\Domain\ValueObject\Commission;
use App\Module\Employee\Tests\TestDouble\EmployeeMother;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/**
 * @codeCoverageIgnore
 */
class EmployeeTest extends TestCase
{
    public function testItCreateEmployee(): void
    {
        $employee = EmployeeMother::createEmployeeH();

        $this->assertCount(1, $employee->getUncommittedEvents());
        $this->assertInstanceOf(EmployeeWasCreatedEvent::class, $employee->getUncommittedEvents()[0]);
    }

    public function testEmployeeSaleProduct(): void
    {
        $employee = EmployeeMother::createEmployeeMC();
        $employee->sale(Commission::createFromFloat(2.5));

        $this->assertCount(2, $employee->getUncommittedEvents());
        $this->assertInstanceOf(EmployeeWasSaleItemEvent::class, $employee->getUncommittedEvents()[1]);
    }

    public function testEmployeeWorkedDay(): void
    {
        $employee = EmployeeMother::createEmployeeMC();
        $employee->workedDay(WorkedDay::create(10, Clock::system()));

        $this->assertCount(2, $employee->getUncommittedEvents());
        $this->assertInstanceOf(EmployeeWasWorkedDayEvent::class, $employee->getUncommittedEvents()[1]);
    }

    public function testGenerateSalaryReportMonthly(): void
    {
        $employee = EmployeeMother::createEmployeeM();
        $employee->workedDay(WorkedDay::create(10, Clock::fixed(new DateTimeImmutable('01-01-2012'))));
        $employee->generateSalaryReport(01, new CalculateMonthlyRewardPolicy());
        $report = $employee->getSalaryReport();

        $this->assertSame(10, $report->getHoursAmount());
        $this->assertSame(2.5, $report->getReward()->getAmount());
        $this->assertCount(3, $employee->getUncommittedEvents());
        $this->assertInstanceOf(EmployeeSalaryReportGeneratedEvent::class, $employee->getUncommittedEvents()[2]);
    }

    public function testGenerateSalaryReportHourly(): void
    {
        $employee = EmployeeMother::createEmployeeH();
        $employee->workedDay(WorkedDay::create(10, Clock::fixed(new DateTimeImmutable('01-01-2012'))));
        $employee->generateSalaryReport(01, new CalculateHourlyRewardPolicy());
        $report = $employee->getSalaryReport();

        $this->assertSame(10, $report->getHoursAmount());
        $this->assertSame(25.0, $report->getReward()->getAmount());
        $this->assertCount(3, $employee->getUncommittedEvents());
        $this->assertInstanceOf(EmployeeSalaryReportGeneratedEvent::class, $employee->getUncommittedEvents()[2]);
    }

    public function testGenerateSalaryReportHourlyWithCommission(): void
    {
        $employee = EmployeeMother::createEmployeeMC();
        $clock    = Clock::fixed(new DateTimeImmutable('01-01-2012'));
        $employee->workedDay(WorkedDay::create(10, $clock));
        $employee->sale(Commission::createFromFloat(100));
        $employee->generateSalaryReport(01, new CalculateMonthlyWithCommissionRewardPolicy());
        $report = $employee->getSalaryReport();

        $this->assertSame(10, $report->getHoursAmount());
        $this->assertSame(102.5, $report->getReward()->getAmount());
        $this->assertCount(4, $employee->getUncommittedEvents());
        $this->assertInstanceOf(EmployeeSalaryReportGeneratedEvent::class, $employee->getUncommittedEvents()[3]);
    }
}
