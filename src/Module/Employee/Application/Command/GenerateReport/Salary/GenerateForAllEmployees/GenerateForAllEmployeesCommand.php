<?php

declare(strict_types=1);

namespace App\Module\Employee\Application\Command\GenerateReport\Salary\GenerateForAllEmployees;

class GenerateForAllEmployeesCommand
{
    private int $month;

    public function __construct(int $month)
    {
        $this->month = $month;
    }

    public function getMonth(): int
    {
        return $this->month;
    }
}
