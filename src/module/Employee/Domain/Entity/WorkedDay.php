<?php

declare(strict_types=1);

namespace App\module\Employee\Domain\Entity;

use App\Infrastructure\Domain\Uuid;
use DateTimeImmutable;

class WorkedDay
{
    private Uuid $id;

    private DateTimeImmutable $time;

    private int $hoursAmount;

    private function __construct(
        Uuid $id,
        DateTimeImmutable $time,
        int $hoursAmount
    )
    {
        $this->id = $id;
        $this->time = $time;
        $this->hoursAmount = $hoursAmount;
    }

    public static function create(int $hoursAmount): self
    {
        return new static(Uuid::generate(), new DateTimeImmutable(), $hoursAmount);
    }
}