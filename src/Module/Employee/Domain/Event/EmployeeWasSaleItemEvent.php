<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\Event;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\Event;
use App\Infrastructure\Domain\EventId;
use App\Module\Employee\Domain\ValueObject\Commission;

/**
 * @codeCoverageIgnore
 */
final class EmployeeWasSaleItemEvent implements Event
{
    private EventId $id;

    private AggregateRootId $aggregateRootId;

    private Commission $Commission;

    public function __construct(EventId $id, AggregateRootId $aggregateRootId, Commission $Commission)
    {
        $this->id = $id;
        $this->aggregateRootId = $aggregateRootId;
        $this->Commission = $Commission;
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
        return $this->Commission;
    }
}
