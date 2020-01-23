<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\Policy\CalculateRewardPolicy;

use App\Module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\Module\Employee\Domain\ValueObject\Reward;
use App\Module\Employee\Domain\ValueObject\Salary;

class CalculateHourlyRewardPolicy implements CalculateRewardPolicyInterface
{
    public function calculate(Salary $salary, int $workedHours, ?array $commission = null): Reward
    {
        return Reward::createFromFloat($salary->getAmount() * $workedHours);
    }

    public function support(RemunerationCalculationWay $remunerationCalculationWay): bool
    {
        return RemunerationCalculationWay::HOURLY()->equals($remunerationCalculationWay);
    }
}
