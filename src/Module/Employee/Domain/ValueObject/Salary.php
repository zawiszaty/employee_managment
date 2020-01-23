<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\ValueObject;

use App\Infrastructure\Domain\Assertion\Assertion;

final class Salary
{
    private float $amount;

    private function __construct(float $amount)
    {
        $this->amount = $amount;
    }

    public static function createFromFloat(float $amount): self
    {
        Assertion::greaterThan($amount, 0);

        return new static($amount);
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
