<?php

declare(strict_types=1);


namespace App\module\Employee\tests\TestDouble;


use App\module\Employee\Domain\Employee;
use App\module\Employee\Domain\ValueObject\PersonalData;
use App\module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\module\Employee\Domain\ValueObject\Salary;

class EmployeeMother
{
    public static function createEmployeeH(
        string $firstName = 'test',
        string $lastName = 'test',
        string $address = 'test',
        float $salary = 2.5
    ): Employee
    {
        return Employee::create(
            PersonalData::createFromString($firstName, $lastName, $address),
            RemunerationCalculationWay::HOURLY(),
            Salary::createFromFloat($salary)
        );
    }

    public static function createEmployeeM(
        string $firstName = 'test',
        string $lastName = 'test',
        string $address = 'test',
        float $salary = 2.5
    ): Employee
    {
        return Employee::create(
            PersonalData::createFromString($firstName, $lastName, $address),
            RemunerationCalculationWay::MONTHLY(),
            Salary::createFromFloat($salary)
        );
    }

    public static function createEmployeeMC(
        string $firstName = 'test',
        string $lastName = 'test',
        string $address = 'test',
        float $salary = 2.5
    ): Employee
    {
        return Employee::create(
            PersonalData::createFromString($firstName, $lastName, $address),
            RemunerationCalculationWay::MONTHLY_WITH_COMMISSION(),
            Salary::createFromFloat($salary)
        );
    }
}