<?php

declare(strict_types=1);

namespace App\Module\Ecommerce\Event;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\Event;
use App\Infrastructure\Domain\EventId;

final class ProductSaleEvent implements Event
{
    private EventId $eventId;

    private float $commission;

    private AggregateRootId $employeeId;

    public function __construct(EventId $eventId, AggregateRootId $employeeId, float $commission)
    {
        $this->eventId = $eventId;
        $this->commission = $commission;
        $this->employeeId = $employeeId;
    }

    public function toArray(): array
    {
        return [
            'event_id' => $this->eventId->toString(),
            'commission' => $this->commission,
            'employee_id' => $this->eventId,
        ];
    }

    public static function fromArray(array $payload): Event
    {
        return new static(
            EventId::fromString($payload['event_id']),
            AggregateRootId::fromString('employee_id'),
            $payload['commission'],
        );
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getCommission(): float
    {
        return $this->commission;
    }

    public function getEmployeeId(): AggregateRootId
    {
        return $this->employeeId;
    }
}
