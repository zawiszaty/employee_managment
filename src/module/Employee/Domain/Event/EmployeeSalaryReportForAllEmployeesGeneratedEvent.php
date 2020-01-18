<?php

declare(strict_types=1);

namespace App\module\Employee\Domain\Event;

use App\Infrastructure\Domain\Event;
use App\Infrastructure\Domain\EventId;
use App\module\Employee\Domain\ValueObject\Reward;

/**
 * @codeCoverageIgnore
 */
class EmployeeSalaryReportForAllEmployeesGeneratedEvent implements Event
{
    private EventId $id;

    private Reward $reward;

    private int $month;

    private int $employeeAmounts;

    private int $hoursAmount;

    public function __construct(Reward $reward, int $month, int $employeeAmounts, int $hoursAmount)
    {
        $this->id = EventId::generate();
        $this->reward = $reward;
        $this->month = $month;
        $this->employeeAmounts = $employeeAmounts;
        $this->hoursAmount = $hoursAmount;
    }

    /**
     * @return EventId
     */
    public function getId(): EventId
    {
        return $this->id;
    }

    /**
     * @return Reward
     */
    public function getReward(): Reward
    {
        return $this->reward;
    }

    /**
     * @return int
     */
    public function getMonth(): int
    {
        return $this->month;
    }

    /**
     * @return int
     */
    public function getEmployeeAmounts(): int
    {
        return $this->employeeAmounts;
    }

    /**
     * @return int
     */
    public function getHoursAmount(): int
    {
        return $this->hoursAmount;
    }
}
