<?php

declare(strict_types=1);

namespace App\module\Employee\Domain\Policy\CalculateRewardPolicy;

use App\module\Employee\Domain\ValueObject\RemunerationCalculationWay;

class CalculateRewardPolicyFactory
{
    private array $policies;

    public function __construct()
    {
        $this->policies = [
            new CalculateMonthlyWithCommissionRewardPolicy(),
            new CalculateMonthlyRewardPolicy(),
            new CalculateHourlyRewardPolicy(),
        ];
    }

    public function getPolicy(RemunerationCalculationWay $remunerationCalculationWay): CalculateRewardPolicyInterface
    {
        /** @var CalculateRewardPolicyInterface $policy */
        foreach ($this->policies as $policy) {
            if ($policy->support($remunerationCalculationWay)) {
                return $policy;
            }
        }
    }
}
