<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\Entity;

use App\Infrastructure\Domain\Assertion\Assertion;
use App\Infrastructure\Domain\Clock;
use App\Infrastructure\Domain\Uuid;
use DateTimeImmutable;

final class WorkedDay
{
    private Uuid $id;

    private int $hoursAmount;

    private DateTimeImmutable $clock;

    private function __construct(
        Uuid $id,
        DateTimeImmutable $clock,
        int $hoursAmount
    ) {
        $this->id = $id;
        $this->hoursAmount = $hoursAmount;
        $this->clock = $clock;
    }

    public static function create(int $hoursAmount, Clock $clock): self
    {
        Assertion::greaterThan($hoursAmount, -1);
        Assertion::lessThan($hoursAmount, 25);

        return new static(Uuid::generate(), $clock->currentDateTime(), $hoursAmount);
    }

    public function getHoursAmount(): int
    {
        return $this->hoursAmount;
    }

    public function getDay(): DateTimeImmutable
    {
        return $this->clock;
    }
}
