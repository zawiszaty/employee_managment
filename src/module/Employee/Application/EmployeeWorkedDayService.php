<?php

declare(strict_types=1);

namespace App\module\Employee\Application;

use App\Infrastructure\Domain\AggregateRootId;
use App\module\Employee\Domain\Employee;
use App\module\Employee\Domain\EmployeeRepositoryInterface;
use App\module\Employee\Domain\Entity\WorkedDay;

final class EmployeeWorkedDayService
{
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function workedDay(
        string $employeeId,
        int $hoursAmount
    ): void {
        /** @var Employee $employee */
        $employee = $this->employeeRepository->get(AggregateRootId::fromString($employeeId));
        $employee->workedByDay(WorkedDay::create($hoursAmount));
        $this->employeeRepository->apply($employee);
        $this->employeeRepository->save();
    }
}
