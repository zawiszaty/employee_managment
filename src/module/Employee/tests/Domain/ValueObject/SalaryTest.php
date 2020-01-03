<?php

namespace App\module\Employee\tests\Domain\ValueObject;

use App\Infrastructure\Domain\DomainException;
use App\module\Employee\Domain\ValueObject\Salary;
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
        $this->assertSame(self::SALARY,$salary->getAmount());
    }

    public function testItCreateValidateNegativeAmount(): void
    {
        $this->expectException(DomainException::class);
        Salary::createFromFloat(-1);
    }
}
