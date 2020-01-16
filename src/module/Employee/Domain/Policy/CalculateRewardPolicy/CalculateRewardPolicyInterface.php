<?php

declare(strict_types=1);


namespace App\module\Employee\Domain\Policy\CalculateRewardPolicy;


use App\module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\module\Employee\Domain\ValueObject\Reward;
use App\module\Employee\Domain\ValueObject\Salary;

interface CalculateRewardPolicyInterface
{
    public function calculate(Salary $salary, int $hoursAmount, ?array $commission = null): Reward;

    public function support(RemunerationCalculationWay $remunerationCalculationWay): bool;
}