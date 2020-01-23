<?php

declare(strict_types=1);

namespace App\module\Employee\Domain;

use App\Infrastructure\Domain\AggregateRoot;
use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\EventId;
use App\module\Employee\Domain\Entity\SalaryReport;
use App\module\Employee\Domain\Entity\WorkedDay;
use App\module\Employee\Domain\Event\EmployeeSalaryReportGeneratedEvent;
use App\module\Employee\Domain\Event\EmployeeWasCreatedEvent;
use App\module\Employee\Domain\Event\EmployeeWasSaleItemEvent;
use App\module\Employee\Domain\Event\EmployeeWasWorkedDayEvent;
use App\module\Employee\Domain\Policy\CalculateRewardPolicy\CalculateRewardPolicyInterface;
use App\module\Employee\Domain\ValueObject\Commission;
use App\module\Employee\Domain\ValueObject\PersonalData;
use App\module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\module\Employee\Domain\ValueObject\Salary;

final class Employee extends AggregateRoot
{
    private AggregateRootId $id;

    private PersonalData $personalData;

    private RemunerationCalculationWay $remunerationCalculationWay;

    /** @var array<Commission> */
    private array $commissions = [];

    /** @var array<WorkedDay> */
    private array $workedDays = [];

    private Salary $salary;

    private SalaryReport $salaryReport;

    private function __construct(
        PersonalData $personalData,
        RemunerationCalculationWay $remunerationCalculationWay,
        Salary $salary
    ) {
        $this->id = AggregateRootId::generate();
        $this->personalData = $personalData;
        $this->remunerationCalculationWay = $remunerationCalculationWay;
        $this->salary = $salary;
    }

    public static function create(
        PersonalData $personalData,
        RemunerationCalculationWay $remunerationCalculationWay,
        Salary $salary
    ): self {
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

    public function workedDay(WorkedDay $workedDay): void
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

    public function generateSalaryReport(int $month, CalculateRewardPolicyInterface $calculateRewardPolicy): void
    {
        $workedHours = 0;

        array_map(static function (WorkedDay $workedDay) use (&$workedHours, $month) {
            if ((int) $workedDay->getClock()->format('m') === $month) {
                $workedHours += $workedDay->getHoursAmount();
            }
        }, $this->workedDays);
        $reward = $calculateRewardPolicy->calculate($this->salary, $workedHours, $this->commissions);
        $this->salaryReport = SalaryReport::create($this->getId(), $reward, $month, $workedHours);
        $this->record(
            new EmployeeSalaryReportGeneratedEvent(
                EventId::generate(),
                $this->id,
                $this->salaryReport
            )
        );
    }

    public function getSalaryReport(): SalaryReport
    {
        return $this->salaryReport;
    }

    public function getRemunerationCalculationWay(): RemunerationCalculationWay
    {
        return $this->remunerationCalculationWay;
    }
}
