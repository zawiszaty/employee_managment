<?php

declare(strict_types=1);


namespace App\module\Employee\Domain\Policy\CalculateRewardPolicy;

use App\module\Employee\Domain\ValueObject\Commission;
use App\module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\module\Employee\Domain\ValueObject\Reward;
use App\module\Employee\Domain\ValueObject\Salary;

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