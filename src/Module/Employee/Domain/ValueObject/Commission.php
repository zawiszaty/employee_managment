<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\ValueObject;

use App\Infrastructure\Domain\Assertion\Assertion;

final class Commission
{
    private float $commission;

    private function __construct(float $commissionValue)
    {
        $this->commission = $commissionValue;
    }

    public static function createFromFloat(float $commissionValue): self
    {
        Assertion::greaterThan($commissionValue, 0);

        return new static($commissionValue);
    }

    public function getCommission(): float
    {
        return $this->commission;
    }
}
