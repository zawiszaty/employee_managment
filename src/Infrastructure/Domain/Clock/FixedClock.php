<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Clock;

use App\Infrastructure\Domain\Clock;
use DateTimeImmutable;

class FixedClock extends Clock
{
    private DateTimeImmutable $dateTime;

    public function __construct(DateTimeImmutable $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function currentDateTime(): DateTimeImmutable
    {
        return $this->dateTime;
    }
}
