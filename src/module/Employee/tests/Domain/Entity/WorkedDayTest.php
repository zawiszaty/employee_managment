<?php

declare(strict_types=1);

namespace App\module\Employee\tests\Domain\Entity;

use App\Infrastructure\Domain\AssertionException;
use App\module\Employee\Domain\Entity\WorkedDay;
use PHPUnit\Framework\TestCase;

/**
 * @codeCoverageIgnore
 */
class WorkedDayTest extends TestCase
{
    public function testItCreateWorkedDay(): void
    {
        $workedDay = WorkedDay::create(2);
        $this->assertSame(2, $workedDay->getHoursAmount());
    }

    public function testItValidateNegativeHoursAmount(): void
    {
        $this->expectException(AssertionException::class);
        WorkedDay::create(-1);
    }

    public function testItValidateToMuchHoursAmount(): void
    {
        $this->expectException(AssertionException::class);
        WorkedDay::create(25);
    }
}
