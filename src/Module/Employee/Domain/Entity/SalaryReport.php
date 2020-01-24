<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\Entity;

use App\Infrastructure\Domain\AggregateRootId;
use App\Module\Employee\Domain\ValueObject\Reward;

final class SalaryReport
{
    private AggregateRootId $employeeId;

    private Reward $reward;

    private int $month;

    private int $hoursAmount;

    private function __construct(AggregateRootId $employeeId, Reward $reward, int $month, int $hoursAmount)
    {
        $this->employeeId = $employeeId;
        $this->reward = $reward;
        $this->month = $month;
        $this->hoursAmount = $hoursAmount;
    }

    public static function create(AggregateRootId $employeeId, Reward $reward, int $month, int $hoursAmount): self
    {
        return new static($employeeId, $reward, $month, $hoursAmount);
    }

    public function getHoursAmount(): int
    {
        return $this->hoursAmount;
    }

    public function getReward(): Reward
    {
        return $this->reward;
    }

    public function getMonth(): int
    {
        return $this->month;
    }
}