<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain;

use App\Infrastructure\Domain\AggregateRoot;
use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\Clock;
use App\Infrastructure\Domain\EventId;
use App\Module\Employee\Domain\Entity\SalaryReport;
use App\Module\Employee\Domain\Entity\SalaryReportType;
use App\Module\Employee\Domain\Entity\WorkedDay;
use App\Module\Employee\Domain\Event\EmployeeSalaryReportGeneratedEvent;
use App\Module\Employee\Domain\Event\EmployeeWasCreatedEvent;
use App\Module\Employee\Domain\Event\EmployeeWasSaleItemEvent;
use App\Module\Employee\Domain\Event\EmployeeWasWorkedDayEvent;
use App\Module\Employee\Domain\Policy\CalculateRewardPolicy\CalculateRewardPolicyInterface;
use App\Module\Employee\Domain\ValueObject\Commission;
use App\Module\Employee\Domain\ValueObject\PersonalData;
use App\Module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\Module\Employee\Domain\ValueObject\Salary;
use App\Module\Employee\Domain\ValueObject\WorkedDaysCollection;

final class Employee extends AggregateRoot
{
    private AggregateRootId $id;

    private PersonalData $personalData;

    private RemunerationCalculationWay $remunerationCalculationWay;

    /** @var array<Commission> */
    private array $commissions = [];

    private WorkedDaysCollection $workedDaysCollection;

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
        $this->workedDaysCollection = new WorkedDaysCollection();
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
            $salary
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
        $this->workedDaysCollection->push($workedDay);
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

    public function generateSalaryReport(Clock $month, CalculateRewardPolicyInterface $calculateRewardPolicy): void
    {
        $workedHours        = $this->workedDaysCollection->sumHoursAmount($month);
        $reward             = $calculateRewardPolicy->calculate($this->salary, $workedHours, $this->commissions);
        $this->salaryReport = SalaryReport::create($this->getId(), $reward, $month, $workedHours, SalaryReportType::SINGLE_EMPLOYEE());
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
