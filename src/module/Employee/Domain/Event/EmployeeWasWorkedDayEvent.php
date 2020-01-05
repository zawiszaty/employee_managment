<?php

declare(strict_types=1);

namespace App\module\Employee\Domain\Event;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\Event;
use App\Infrastructure\Domain\EventId;
use App\module\Employee\Domain\Entity\WorkedDay;

/**
 * @codeCoverageIgnore
 */
class EmployeeWasWorkedDayEvent implements Event
{
    private EventId $id;

    private AggregateRootId $aggregateId;

    private WorkedDay $workedDay;

    public function __construct(EventId $id, AggregateRootId $aggregateId, WorkedDay $workedDay)
    {
        $this->id = $id;
        $this->aggregateId = $aggregateId;
        $this->workedDay = $workedDay;
    }

    public function getId(): EventId
    {
        return $this->id;
    }

    public function getAggregateId(): AggregateRootId
    {
        return $this->aggregateId;
    }

    public function getWorkedDay(): WorkedDay
    {
        return $this->workedDay;
    }
}
