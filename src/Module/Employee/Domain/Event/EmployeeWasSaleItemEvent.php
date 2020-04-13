<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\Event;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\Clock;
use App\Infrastructure\Domain\Event;
use App\Infrastructure\Domain\EventId;
use App\Module\Employee\Domain\ValueObject\Commission;
use DateTimeImmutable;

/**
 * @codeCoverageIgnore
 */
final class EmployeeWasSaleItemEvent implements Event
{
    private EventId $id;

    private AggregateRootId $aggregateRootId;

    private Commission $commission;

    public function __construct(EventId $id, Commission $commission)
    {
        $this->id         = $id;
        $this->commission = $commission;
    }

    public function getId(): EventId
    {
        return $this->id;
    }

    public function getAggregateRootId(): AggregateRootId
    {
        return $this->aggregateRootId;
    }

    public function getCommission(): Commission
    {
        return $this->commission;
    }

    public static function fromArray(array $payload): Event
    {
        return new static(
            EventId::fromString($payload['event_id']),
            Commission::create(
                $payload['commission']['amount'],
                AggregateRootId::fromString($payload['commission']['employee_id']),
                Clock::fixed(new DateTimeImmutable(($payload['commission']['month'])))
            )
        );
    }

    public function toArray(): array
    {
        return [
            'event_id'          => $this->id->toString(),
            'aggregate_root_id' => $this->aggregateRootId->toString(),
            'commission'        => [
                'amount'      => $this->commission->getCommission(),
                'employee_id' => $this->commission->getEmployeeId()->toString(),
                'month'       => $this->commission->getMonth()->currentDateTime()->format('d:m:y'),
            ]
        ];
    }
}
