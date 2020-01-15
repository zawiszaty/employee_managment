<?php

declare(strict_types=1);

namespace App\module\Employee\Application\Command\EmployeeWorkedDay;

class EmployeeWorkedDayCommand
{
    private string $employeeId;

    private int $hoursAmount;

    public function __construct(
        string $employeeId,
        int $hoursAmount
    ) {
        $this->employeeId = $employeeId;
        $this->hoursAmount = $hoursAmount;
    }

    public function getEmployeeId(): string
    {
        return $this->employeeId;
    }

    public function getHoursAmount(): int
    {
        return $this->hoursAmount;
    }
}
