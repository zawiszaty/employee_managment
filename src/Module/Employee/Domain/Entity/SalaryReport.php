<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\Entity;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\Clock;
use App\Module\Employee\Domain\ValueObject\Reward;

final class SalaryReport
{
    private AggregateRootId $employeeId;

    private Reward $reward;

    private Clock $month;

    private int $hoursAmount;

    private SalaryReportType $salaryReportType;

    private function __construct(AggregateRootId $employeeId, Reward $reward, Clock $month, int $hoursAmount, SalaryReportType $salaryReportType)
    {
        $this->employeeId  = $employeeId;
        $this->reward      = $reward;
        $this->month       = $month;
        $this->hoursAmount = $hoursAmount;
        $this->salaryReportType = $salaryReportType;
    }

    public static function create(AggregateRootId $employeeId, Reward $reward, Clock $month, int $hoursAmount, SalaryReportType $salaryReportType): self
    {
        return new static($employeeId, $reward, $month, $hoursAmount, $salaryReportType);
    }

    public function getHoursAmount(): int
    {
        return $this->hoursAmount;
    }

    public function getReward(): Reward
    {
        return $this->reward;
    }

    public function getMonth(): Clock
    {
        return $this->month;
    }

    public function getSalaryReportType(): SalaryReportType
    {
        return $this->salaryReportType;
    }
}
