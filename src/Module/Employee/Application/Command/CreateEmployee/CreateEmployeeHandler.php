<?php

declare(strict_types=1);

namespace App\Module\Employee\Application\Command\CreateEmployee;

use App\Infrastructure\Domain\CommandHandler;
use App\Module\Employee\Domain\Employee;
use App\Module\Employee\Domain\EmployeeRepositoryInterface;
use App\Module\Employee\Domain\ValueObject\PersonalData;
use App\Module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\Module\Employee\Domain\ValueObject\Salary;

class CreateEmployeeHandler extends CommandHandler
{
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function handle(CreateEmployeeCommand $command): void
    {
        $employee = Employee::create(
            PersonalData::createFromString($command->getFirstName(), $command->getLastName(), $command->getAddress()),
            new RemunerationCalculationWay($command->getRemunerationCalculationWay()),
            Salary::createFromFloat($command->getSalary()),
        );
        $this->employeeRepository->apply($employee);
        $this->employeeRepository->save();
    }
}
