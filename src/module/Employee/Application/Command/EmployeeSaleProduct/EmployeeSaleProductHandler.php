<?php

declare(strict_types=1);

namespace App\module\Employee\Application\Command\EmployeeSaleProduct;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\CommandHandler;
use App\module\Employee\Domain\EmployeeRepositoryInterface;
use App\module\Employee\Domain\ValueObject\Commission;

class EmployeeSaleProductHandler extends CommandHandler
{
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function handle(EmployeeSaleProductCommand $command): void
    {
        $employee = $this->employeeRepository->get(AggregateRootId::fromString($command->getEmployeeId()));
        $employee->sale(Commission::createFromFloat($command->getCollision()));
        $this->employeeRepository->apply($employee);
        $this->employeeRepository->save();
    }
}
