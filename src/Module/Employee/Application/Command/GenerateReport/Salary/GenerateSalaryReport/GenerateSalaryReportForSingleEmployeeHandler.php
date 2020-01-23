<?php

declare(strict_types=1);

namespace App\Module\Employee\Application\Command\GenerateReport\Salary\GenerateSalaryReport;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\CommandHandler;
use App\Module\Employee\Domain\Employee;
use App\Module\Employee\Domain\EmployeeRepositoryInterface;
use App\Module\Employee\Domain\Policy\CalculateRewardPolicy\CalculateRewardPolicyFactory;

class GenerateSalaryReportForSingleEmployeeHandler extends CommandHandler
{
    private EmployeeRepositoryInterface $employeeRepository;

    private CalculateRewardPolicyFactory $calculateRewardPolicyFactory;

    public function __construct(EmployeeRepositoryInterface $employeeRepository, CalculateRewardPolicyFactory $calculateRewardPolicyFactory)
    {
        $this->employeeRepository = $employeeRepository;
        $this->calculateRewardPolicyFactory = $calculateRewardPolicyFactory;
    }

    public function handle(GenerateSalaryReportForSingleEmployeeCommand $command): void
    {
        /** @var Employee $employee */
        $employee = $this->employeeRepository->get(AggregateRootId::fromString($command->getEmployeeId()));
        $employee->generateSalaryReport($command->getMonth(), $this->calculateRewardPolicyFactory->getPolicy($employee->getRemunerationCalculationWay()));
        $this->employeeRepository->apply($employee);
        $this->employeeRepository->save();
    }
}
