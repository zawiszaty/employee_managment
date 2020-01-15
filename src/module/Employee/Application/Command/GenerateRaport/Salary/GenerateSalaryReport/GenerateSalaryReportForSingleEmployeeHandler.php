<?php

declare(strict_types=1);

namespace App\module\Employee\Application\Command\GenerateRaport\Salary\GenerateSalaryReport;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\CommandHandler;
use App\module\Employee\Domain\Employee;
use App\module\Employee\Domain\EmployeeRepositoryInterface;

class GenerateSalaryReportForSingleEmployeeHandler extends CommandHandler
{
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function handle(GenerateSalaryReportForSingleEmployeeCommand $command): void
    {
        /** @var Employee $employee */
        $employee = $this->employeeRepository->get(AggregateRootId::fromString($command->getEmployeeId()));
        $employee->generateSalaryReport($command->getMonth());
        $this->employeeRepository->apply($employee);
        $this->employeeRepository->save();
    }
}
