<?php

declare(strict_types=1);

namespace App\Module\Employee\Application\Command\GenerateReport\Salary\GenerateForAllEmployees;

use App\Infrastructure\Domain\Clock;

class GenerateForAllEmployeesCommand
{
    private Clock $month;

    public function __construct(Clock $month)
    {
        $this->month = $month;
    }

    public function getMonth(): Clock
    {
        return $this->month;
    }
}
