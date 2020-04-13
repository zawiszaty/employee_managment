<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\Domain\Entity;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\AssertionException;
use App\Infrastructure\Domain\Clock;
use App\Module\Employee\Domain\Entity\WorkedDay;
use PHPUnit\Framework\TestCase;

/**
 * @codeCoverageIgnore
 */
class WorkedDayTest extends TestCase
{
    public function testItCreateWorkedDay(): void
    {
        $workedDay = WorkedDay::create(2, Clock::system(), AggregateRootId::generate());
        $this->assertSame(2, $workedDay->getHoursAmount());
    }

    public function testItValidateNegativeHoursAmount(): void
    {
        $this->expectException(AssertionException::class);
        WorkedDay::create(-1, Clock::system(), AggregateRootId::generate());
    }

    public function testItValidateToMuchHoursAmount(): void
    {
        $this->expectException(AssertionException::class);
        WorkedDay::create(25, Clock::system(), AggregateRootId::generate());
    }
}
