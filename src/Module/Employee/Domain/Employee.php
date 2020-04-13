<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain;

use App\Infrastructure\Domain\AggregateRoot;
use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\Clock;
use App\Infrastructure\Domain\EventId;
use App\Infrastructure\Domain\Uuid;
use App\Module\Employee\Domain\Entity\SalaryReport;
use App\Module\Employee\Domain\Entity\SalaryReportType;
use App\Module\Employee\Domain\Entity\WorkedDay;
use App\Module\Employee\Domain\Event\EmployeeSalaryReportGeneratedEvent;
use App\Module\Employee\Domain\Event\EmployeeWasCreatedEvent;
use App\Module\Employee\Domain\Event\EmployeeWasSaleItemEvent;
use App\Module\Employee\Domain\Event\EmployeeWasWorkedDayEvent;
use App\Module\Employee\Domain\Policy\CalculateRewardPolicy\CalculateRewardPolicyInterface;
use App\Module\Employee\Domain\ValueObject\Commission;
use App\Module\Employee\Domain\ValueObject\Path;
use App\Module\Employee\Domain\ValueObject\PersonalData;
use App\Module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\Module\Employee\Domain\ValueObject\Salary;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class Employee extends AggregateRoot
{
    private AggregateRootId $id;

    private PersonalData $personalData;

    private RemunerationCalculationWay $remunerationCalculationWay;

    /** @var Collection<Commission> */
    private Collection $commissions;

    /** @var Collection<WorkedDay> */
    private Collection $workedDaysCollection;

    private Salary $salary;

    /** @var Collection<SalaryReport> */
    private Collection $salaryReportsCollection;

    private function __construct(
        PersonalData $personalData,
        RemunerationCalculationWay $remunerationCalculationWay,
        Salary $salary
    )
    {
        $this->id                         = AggregateRootId::generate();
        $this->personalData               = $personalData;
        $this->remunerationCalculationWay = $remunerationCalculationWay;
        $this->salary                     = $salary;
        $this->workedDaysCollection       = new ArrayCollection();
        $this->commissions                = new ArrayCollection();
        $this->salaryReportsCollection    = new ArrayCollection();
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
            EventId::generate(),
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
            $commission
        ));
    }

    public function workedDay(WorkedDay $workedDay): void
    {
        $this->workedDaysCollection->add($workedDay);
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

    public function generateSalaryReport(Clock $month, CalculateRewardPolicyInterface $calculateRewardPolicy, int $workedHours, Path $path): void
    {
        $reward       = $calculateRewardPolicy->calculate($this->salary, $workedHours, $this->commissions);
        $salaryReport = SalaryReport::create(Uuid::generate(), $this->getId(), $reward, $month, $workedHours, SalaryReportType::SINGLE_EMPLOYEE(), $path);
        $this->salaryReportsCollection->add($salaryReport);
        $this->record(
            new EmployeeSalaryReportGeneratedEvent(
                EventId::generate(),
                $this->id,
                $salaryReport
            )
        );
    }

    public function getSalaryReportsCollection(): Collection
    {
        return $this->salaryReportsCollection;
    }

    public function getRemunerationCalculationWay(): RemunerationCalculationWay
    {
        return $this->remunerationCalculationWay;
    }

    public function getCommissions(): Collection
    {
        return $this->commissions;
    }

    public function getWorkedDaysCollection(): Collection
    {
        return $this->workedDaysCollection;
    }
}
