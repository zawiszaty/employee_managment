<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\Policy\CalculateRewardPolicy;

use App\Module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\Module\Employee\Domain\ValueObject\Reward;
use App\Module\Employee\Domain\ValueObject\Salary;

interface CalculateRewardPolicyInterface
{
    public function calculate(Salary $salary, int $hoursAmount, ?array $commission = null): Reward;

    public function support(RemunerationCalculationWay $remunerationCalculationWay): bool;
}
