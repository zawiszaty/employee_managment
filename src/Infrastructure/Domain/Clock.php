<?php

declare(strict_types=1);


namespace App\Infrastructure\Domain;

use App\Infrastructure\Domain\Clock\FixedClock;
use App\Infrastructure\Domain\Clock\SystemClock;

abstract class Clock
{
    abstract public function currentDateTime(): \DateTimeImmutable;

    public static function system(): self
    {
        return new SystemClock();
    }

    public static function fixed(\DateTimeImmutable $dateTime): self
    {
        return new FixedClock($dateTime);
    }
}