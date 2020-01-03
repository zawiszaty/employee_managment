<?php

declare(strict_types=1);

namespace App\module\Employee\Domain;

use App\Infrastructure\Domain\AggregateRoot;
use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\EventId;
use App\module\Employee\Domain\Entity\WorkedDay;
use App\module\Employee\Domain\Event\EmployeeWasCreatedEvent;
use App\module\Employee\Domain\Event\EmployeeWasSaleItemEvent;
use App\module\Employee\Domain\Event\EmployeeWasWorkedDayEvent;
use App\module\Employee\Domain\ValueObject\Commission;
use App\module\Employee\Domain\ValueObject\PersonalData;
use App\module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\module\Employee\Domain\ValueObject\Salary;

final class Employee extends AggregateRoot
{
    private AggregateRootId $id;

    private PersonalData $personalData;

    private RemunerationCalculationWay $remunerationCalculationWay;

    private array $commissions = [];

    private array $workedDays = [];

    private Salary $salary;

    private function __construct(
        PersonalData $personalData,
        RemunerationCalculationWay $remunerationCalculationWay,
        Salary $salary
    )
    {
        $this->id = AggregateRootId::generate();
        $this->personalData = $personalData;
        $this->remunerationCalculationWay = $remunerationCalculationWay;
        $this->salary = $salary;
    }

    public static function create(
        PersonalData $personalData,
        RemunerationCalculationWay $remunerationCalculationWay,
        Salary $salary
    ): self
    {
        $employee = new static(
            $personalData,
            $remunerationCalculationWay,
            $salary,
        );
        $employee->record(new EmployeeWasCreatedEvent(
            $employee->id,
            $personalData,
            $remunerationCalculationWay,
        ));

        return $employee;
    }

    public function sale(Commission $commission): void
    {
        $this->commissions[] = $commission;
        $this->record(new EmployeeWasSaleItemEvent(
            EventId::generate(),
            $this->id,
            $commission
        ));
    }

    public function workedByDay(WorkedDay $workedDay): void
    {
        $this->workedDays[] = $workedDay;
        $this->record(new EmployeeWasWorkedDayEvent(
            EventId::generate(),
            $this->id,
            $workedDay,
        ));
    }

    public function getId(): AggregateRootId
    {
        return $this->id;
    }

    public function getPersonalData(): PersonalData
    {
        return $this->personalData;
    }

    public function getRemunerationCalculationWay(): RemunerationCalculationWay
    {
        return $this->remunerationCalculationWay;
    }

    public function getSalary(): Salary
    {
        return $this->salary;
    }
}