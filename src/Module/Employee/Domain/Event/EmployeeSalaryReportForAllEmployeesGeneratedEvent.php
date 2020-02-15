<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\Event;

use App\Infrastructure\Domain\Clock;
use App\Infrastructure\Domain\Event;
use App\Infrastructure\Domain\EventId;
use App\Module\Employee\Domain\ValueObject\Reward;

/**
 * @codeCoverageIgnore
 */
class EmployeeSalaryReportForAllEmployeesGeneratedEvent implements Event
{
    private EventId $id;

    private Reward $reward;

    private Clock $month;

    private int $employeeAmounts;

    private int $hoursAmount;

    public function __construct(Reward $reward, Clock $month, int $employeeAmounts, int $hoursAmount)
    {
        $this->id = EventId::generate();
        $this->reward = $reward;
        $this->month = $month;
        $this->employeeAmounts = $employeeAmounts;
        $this->hoursAmount = $hoursAmount;
    }

    public function getId(): EventId
    {
        return $this->id;
    }

    public function getReward(): Reward
    {
        return $this->reward;
    }

    public function getMonth(): Clock
    {
        return $this->month;
    }

    public function getEmployeeAmounts(): int
    {
        return $this->employeeAmounts;
    }

    public function getHoursAmount(): int
    {
        return $this->hoursAmount;
    }
}
