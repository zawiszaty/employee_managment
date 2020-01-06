<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Clock;

use App\Infrastructure\Domain\Clock;
use DateTimeImmutable;

final class SystemClock extends Clock
{
    public function currentDateTime(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
