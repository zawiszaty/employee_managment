<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\Domain\ValueObject;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\AssertionException;
use App\Infrastructure\Domain\Clock;
use App\Module\Employee\Domain\ValueObject\Commission;
use PHPUnit\Framework\TestCase;

/**
 * @codeCoverageIgnore
 */
final class CommissionTest extends TestCase
{
    private const COMMISSION = 2.5;

    public function testItCreateCommission(): void
    {
        $commission = Commission::create(self::COMMISSION, AggregateRootId::generate(), Clock::system());
        $this->assertSame(self::COMMISSION, $commission->getCommission());
    }

    public function testItValidateNegativeCommission(): void
    {
        $this->expectException(AssertionException::class);
        Commission::create(-2.5, AggregateRootId::generate(), Clock::system());
    }
}
