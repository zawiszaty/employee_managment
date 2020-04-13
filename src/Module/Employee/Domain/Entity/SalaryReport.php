<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\Entity;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\Clock;
use App\Infrastructure\Domain\Uuid;
use App\Module\Employee\Domain\ValueObject\Path;
use App\Module\Employee\Domain\ValueObject\Reward;

final class SalaryReport
{
    private Uuid $id;

    private ?AggregateRootId $employeeId;

    private Reward $reward;

    private Clock $month;

    private int $hoursAmount;

    private Path $path;

    private SalaryReportType $salaryReportType;

    private function __construct(Uuid $id, ?AggregateRootId $employeeId, Reward $reward, Clock $month, int $hoursAmount, SalaryReportType $salaryReportType, Path $path)
    {
        $this->employeeId       = $employeeId;
        $this->reward           = $reward;
        $this->month            = $month;
        $this->hoursAmount      = $hoursAmount;
        $this->salaryReportType = $salaryReportType;
        $this->id               = $id;
        $this->path             = $path;
    }

    public static function create(Uuid $id, ?AggregateRootId $employeeId, Reward $reward, Clock $month, int $hoursAmount, SalaryReportType $salaryReportType, Path $path): self
    {
        return new static($id, $employeeId, $reward, $month, $hoursAmount, $salaryReportType, $path);
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

    public function getEmployeeId(): AggregateRootId
    {
        return $this->employeeId;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getPath(): Path
    {
        return $this->path;
    }
}
