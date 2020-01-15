<?php

declare(strict_types=1);


namespace App\module\Employee\Application\Command\CreateEmployee;


use App\Infrastructure\Domain\CommandHandler;
use App\module\Employee\Domain\Employee;
use App\module\Employee\Domain\EmployeeRepositoryInterface;
use App\module\Employee\Domain\ValueObject\PersonalData;
use App\module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\module\Employee\Domain\ValueObject\Salary;

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