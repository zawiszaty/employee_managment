<?php

declare(strict_types=1);

namespace App\module\Employee\Domain;

use App\Infrastructure\Domain\DomainException;
use App\module\Employee\Domain\Event\EmployeeWasCreatedEvent;
use App\module\Employee\Domain\Event\EmployeeWasSaleItemEvent;
use App\module\Employee\Domain\ValueObject\Commission;
use App\module\Employee\Domain\ValueObject\PersonalData;
use App\module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\module\Employee\Domain\ValueObject\Salary;
use PHPUnit\Framework\TestCase;

class EmployeeTest extends TestCase
{
    public function testItCreateEmployee(): void
    {
        throw new DomainException('test');
        $employee = Employee::create(
            PersonalData::createFromString('test', 'test', 'test'),
            RemunerationCalculationWay::HOURLY(),
            Salary::createFromFloat(2.5)
        );
        $this->assertCount(1, $employee->getUncommittedEvents());
        $this->assertInstanceOf(EmployeeWasCreatedEvent::class, $employee->getUncommittedEvents()[0]);
    }

    public function testEmployeeSaleProduct(): void
    {
        $employee = Employee::create(
            PersonalData::createFromString('test', 'test', 'test'),
            RemunerationCalculationWay::MONTHLY_WITH_COMMISSION(),
            Salary::createFromFloat(2.5),
            );
        $employee->sale(Commission::createFromFloat(2.5));
        $this->assertCount(2, $employee->getUncommittedEvents());
        $this->assertInstanceOf(EmployeeWasSaleItemEvent::class, $employee->getUncommittedEvents()[1]);
    }
}
