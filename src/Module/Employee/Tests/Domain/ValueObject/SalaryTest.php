<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\Domain\ValueObject;

use App\Infrastructure\Domain\AssertionException;
use App\Module\Employee\Domain\ValueObject\Salary;
use PHPUnit\Framework\TestCase;

/**
 * @codeCoverageIgnore
 */
class SalaryTest extends TestCase
{
    private const SALARY = 260.0;

    public function testItCreateSalary(): void
    {
        $salary = Salary::createFromFloat(self::SALARY);
        $this->assertSame(self::SALARY, $salary->getAmount());
    }

    public function testItCreateValidateNegativeAmount(): void
    {
        $this->expectException(AssertionException::class);
        Salary::createFromFloat(-1);
    }
}
