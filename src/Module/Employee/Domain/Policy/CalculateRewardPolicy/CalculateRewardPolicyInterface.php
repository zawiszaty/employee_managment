<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\Policy\CalculateRewardPolicy;

use App\Module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\Module\Employee\Domain\ValueObject\Reward;
use App\Module\Employee\Domain\ValueObject\Salary;
use Doctrine\Common\Collections\Collection;

interface CalculateRewardPolicyInterface
{
    public function calculate(Salary $salary, int $hoursAmount, ?Collection $commission = null): Reward;

    public function support(RemunerationCalculationWay $remunerationCalculationWay): bool;
}
