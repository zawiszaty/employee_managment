<?php

declare(strict_types=1);

namespace App\Infrastructure\Tests\Domain\Clock;

use App\Infrastructure\Domain\Clock\FixedClock;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/**
 * @codeCoverageIgnore
 */
class FixedClockTest extends TestCase
{
    public function testItCreateTime(): void
    {
        $time = new DateTimeImmutable();
        $clock = FixedClock::fixed($time);
        $this->assertSame($time->getTimestamp(), $clock->currentDateTime()->getTimestamp());
    }
}
