<?php

declare(strict_types=1);

namespace App\module\Employee\Application;

use App\Infrastructure\Domain\AggregateRootId;
use App\module\Employee\Domain\EmployeeRepositoryInterface;
use App\module\Employee\Domain\ValueObject\Commission;

final class EmployeeSaleProductService
{
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function sale(
        string $employeeId,
        float $collision
    ): void
    {
        $employee = $this->employeeRepository->get(AggregateRootId::fromString($employeeId));
        $employee->sale(Commission::createFromFloat($collision));
        $this->employeeRepository->apply($employee);
        $this->employeeRepository->save();
    }
}
