<?php

declare(strict_types=1);

namespace App\module\Employee\Domain\Policy\CalculateRewardPolicy;

use App\module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\module\Employee\Domain\ValueObject\Reward;
use App\module\Employee\Domain\ValueObject\Salary;

class CalculateMonthlyRewardPolicy implements CalculateRewardPolicyInterface
{
    public function calculate(Salary $salary, int $workedHours, ?array $commission = null): Reward
    {
        return Reward::createFromFloat($salary->getAmount());
    }

    public function support(RemunerationCalculationWay $remunerationCalculationWay): bool
    {
        return RemunerationCalculationWay::MONTHLY()->equals($remunerationCalculationWay);
    }
}
