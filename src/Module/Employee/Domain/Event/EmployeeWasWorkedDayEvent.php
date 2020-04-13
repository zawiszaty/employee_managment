<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\Event;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\Clock;
use App\Infrastructure\Domain\Event;
use App\Infrastructure\Domain\EventId;
use App\Module\Employee\Domain\Entity\WorkedDay;
use DateTimeImmutable;

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

    public function toArray(): array
    {
        return [
            'event_id' => $this->id->toString(),
            'aggregate_root_id' => $this->aggregateId->toString(),
            'worked_day' => [
                'hours_amount' => $this->workedDay->getHoursAmount(),
                'day' => $this->workedDay->getDay()->format('d:m:y'),
            ],
        ];
    }

    public static function fromArray(array $payload): Event
    {
        return new static(
            EventId::fromString($payload['event_id']),
            AggregateRootId::fromString($payload['aggregate_root_id']),
            WorkedDay::create($payload['worked_day']['hours_amount'], Clock::fixed(new DateTimeImmutable($payload['worked_day']['day'])), AggregateRootId::fromString($payload['aggregate_root_id']))
        );
    }
}
