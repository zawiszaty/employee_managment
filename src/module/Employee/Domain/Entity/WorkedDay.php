<?php

declare(strict_types=1);

namespace App\module\Employee\Domain\Entity;

use App\Infrastructure\Domain\Assertion\Assertion;
use App\Infrastructure\Domain\Clock;
use App\Infrastructure\Domain\Uuid;

final class WorkedDay
{
    private Uuid $id;

    private int $hoursAmount;

    private Clock $clock;

    private function __construct(
        Uuid $id,
        Clock $clock,
        int $hoursAmount
    )
    {
        $this->id = $id;
        $this->hoursAmount = $hoursAmount;
        $this->clock = $clock;
    }

    public static function create(int $hoursAmount): self
    {
        Assertion::greaterThan($hoursAmount, -1);
        Assertion::lessThan($hoursAmount, 25);

        return new static(Uuid::generate(), Clock\SystemClock::system(), $hoursAmount);
    }

    public function getHoursAmount(): int
    {
        return $this->hoursAmount;
    }
}
