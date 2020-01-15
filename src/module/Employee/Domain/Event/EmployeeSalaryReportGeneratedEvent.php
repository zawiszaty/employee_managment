<?php

declare(strict_types=1);

namespace App\module\Employee\Domain\Event;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\Event;
use App\Infrastructure\Domain\EventId;
use App\module\Employee\Domain\ValueObject\Salary;

/**
 * @codeCoverageIgnore
 */
class EmployeeSalaryReportGeneratedEvent implements Event
{
    private EventId $id;

    private AggregateRootId $aggregateId;

    private int $hoursAmount;

    private Salary $salary;

    private int $month;

    public function __construct(EventId $id, AggregateRootId $aggregateId, int $hoursAmount, Salary $salary, int $month)
    {
        $this->id = $id;
        $this->aggregateId = $aggregateId;
        $this->hoursAmount = $hoursAmount;
        $this->salary = $salary;
        $this->month = $month;
    }

    public function getId(): EventId
    {
        return $this->id;
    }

    public function getAggregateId(): AggregateRootId
    {
        return $this->aggregateId;
    }

    public function getHoursAmount(): int
    {
        return $this->hoursAmount;
    }

    public function getSalary(): Salary
    {
        return $this->salary;
    }

    public function getMonth(): int
    {
        return $this->month;
    }
}
