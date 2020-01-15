<?php

declare(strict_types=1);

namespace App\module\Employee\Application\Command\GenerateRaport\Salary\GenerateSalaryReport;

class GenerateSalaryReportForSingleEmployeeCommand
{
    private string $employeeId;

    private int $month;

    public function __construct(string $employeeId, int $month)
    {
        $this->employeeId = $employeeId;
        $this->month = $month;
    }

    public function getEmployeeId(): string
    {
        return $this->employeeId;
    }

    public function getMonth(): int
    {
        return $this->month;
    }
}
