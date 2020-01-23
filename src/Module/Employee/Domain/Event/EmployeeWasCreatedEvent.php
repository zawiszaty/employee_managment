<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\Event;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\Event;
use App\Infrastructure\Domain\EventId;
use App\Module\Employee\Domain\ValueObject\PersonalData;
use App\Module\Employee\Domain\ValueObject\RemunerationCalculationWay;

/**
 * @codeCoverageIgnore
 */
final class EmployeeWasCreatedEvent implements Event
{
    private EventId $id;

    private EventId $eventId;

    private PersonalData $personalData;

    private RemunerationCalculationWay $remunerationCalculationWay;

    private AggregateRootId $aggregateRootId;

    public function __construct(
        AggregateRootId $aggregateRootId,
        PersonalData $personalData,
        RemunerationCalculationWay $remunerationCalculationWay
    ) {
        $this->eventId = EventId::generate();
        $this->personalData = $personalData;
        $this->remunerationCalculationWay = $remunerationCalculationWay;
        $this->aggregateRootId = $aggregateRootId;
    }

    public function getId(): EventId
    {
        return $this->id;
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getPersonalData(): PersonalData
    {
        return $this->personalData;
    }

    public function getRemunerationCalculationWay(): RemunerationCalculationWay
    {
        return $this->remunerationCalculationWay;
    }

    public function getAggregateRootId(): AggregateRootId
    {
        return $this->aggregateRootId;
    }
}
