<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\Policy\CalculateRewardPolicy;

use App\Module\Employee\Domain\ValueObject\Commission;
use App\Module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\Module\Employee\Domain\ValueObject\Reward;
use App\Module\Employee\Domain\ValueObject\Salary;

class CalculateMonthlyWithCommissionRewardPolicy implements CalculateRewardPolicyInterface
{
    public function calculate(Salary $salary, int $workedHours, ?array $commissions = null): Reward
    {
        $rewardAmount = 0;

        /** @var Commission $commission */
        foreach ($commissions as $commission) {
            $rewardAmount += $commission->getCommission();
        }

        return Reward::createFromFloat($salary->getAmount() + $rewardAmount);
    }

    public function support(RemunerationCalculationWay $remunerationCalculationWay): bool
    {
        return RemunerationCalculationWay::MONTHLY_WITH_COMMISSION()->equals($remunerationCalculationWay);
    }
}
