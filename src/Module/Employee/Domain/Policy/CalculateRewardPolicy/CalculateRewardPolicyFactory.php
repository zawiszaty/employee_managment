<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\Policy\CalculateRewardPolicy;

use App\Infrastructure\Domain\DomainException;
use App\Module\Employee\Domain\ValueObject\RemunerationCalculationWay;

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

        throw new DomainException('Missing policy!!!!!!');
    }
}
