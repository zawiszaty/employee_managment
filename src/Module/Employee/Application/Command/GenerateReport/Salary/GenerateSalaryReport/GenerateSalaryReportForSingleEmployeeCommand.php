<?php

declare(strict_types=1);

namespace App\Module\Employee\Application\Command\GenerateReport\Salary\GenerateSalaryReport;

use DateTimeImmutable;

class GenerateSalaryReportForSingleEmployeeCommand
{
    private string $employeeId;

    private DateTimeImmutable $month;

    public function __construct(string $employeeId, DateTimeImmutable $month)
    {
        $this->employeeId = $employeeId;
        $this->month = $month;
    }

    public function getEmployeeId(): string
    {
        return $this->employeeId;
    }

    public function getTime(): DateTimeImmutable
    {
        return $this->month;
    }
}
