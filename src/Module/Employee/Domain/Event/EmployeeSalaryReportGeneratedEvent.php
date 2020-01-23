<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\Event;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\Event;
use App\Infrastructure\Domain\EventId;
use App\Module\Employee\Domain\Entity\SalaryReport;

/**
 * @codeCoverageIgnore
 */
class EmployeeSalaryReportGeneratedEvent implements Event
{
    private EventId $id;

    private AggregateRootId $aggregateId;

    private SalaryReport $salaryReport;

    public function __construct(EventId $id, AggregateRootId $aggregateId, SalaryReport $salaryReport)
    {
        $this->id = $id;
        $this->aggregateId = $aggregateId;
        $this->salaryReport = $salaryReport;
    }

    public function getId(): EventId
    {
        return $this->id;
    }

    public function getAggregateId(): AggregateRootId
    {
        return $this->aggregateId;
    }

    public function getSalaryReport(): SalaryReport
    {
        return $this->salaryReport;
    }
}
