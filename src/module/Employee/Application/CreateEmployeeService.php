<?php

declare(strict_types=1);

namespace App\module\Employee\Application;

use App\module\Employee\Domain\Employee;
use App\module\Employee\Domain\EmployeeRepositoryInterface;
use App\module\Employee\Domain\ValueObject\PersonalData;
use App\module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\module\Employee\Domain\ValueObject\Salary;

final class CreateEmployeeService
{
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function create(
        string $firstName,
        string $lastName,
        string $address,
        string $remunerationCalculationWay,
        float $salary
    ): void {
        $employee = Employee::create(
            PersonalData::createFromString($firstName, $lastName, $address),
            new RemunerationCalculationWay($remunerationCalculationWay),
            Salary::createFromFloat($salary),
        );
        $this->employeeRepository->apply($employee);
        $this->employeeRepository->save();
    }
}
