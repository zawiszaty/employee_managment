<?php

declare(strict_types=1);

namespace App\Infrastructure\tests\Domain\Clock;

use App\Infrastructure\Domain\Clock\SystemClock;
use PHPUnit\Framework\TestCase;

/**
 * @codeCoverageIgnore
 */
class SystemClockTest extends TestCase
{
    public function testItCreateTime(): void
    {
        $clock = new SystemClock();
        $time = $clock->currentDateTime();
        $this->assertInstanceOf(\DateTimeImmutable::class, $time);
    }
}
