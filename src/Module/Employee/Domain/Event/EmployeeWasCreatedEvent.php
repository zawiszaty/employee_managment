<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\Event;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\Event;
use App\Infrastructure\Domain\EventId;
use App\Module\Employee\Domain\ValueObject\PersonalData;
use App\Module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\Module\Employee\Domain\ValueObject\Salary;

/**
 * @codeCoverageIgnore
 */
final class EmployeeWasCreatedEvent implements Event
{
    private EventId $eventId;

    private PersonalData $personalData;

    private RemunerationCalculationWay $remunerationCalculationWay;

    private AggregateRootId $aggregateRootId;

    private Salary $salary;

    public function __construct(
        EventId $eventId,
        AggregateRootId $aggregateRootId,
        PersonalData $personalData,
        RemunerationCalculationWay $remunerationCalculationWay,
        Salary $salary
    ) {
        $this->eventId = $eventId;
        $this->personalData = $personalData;
        $this->remunerationCalculationWay = $remunerationCalculationWay;
        $this->aggregateRootId = $aggregateRootId;
        $this->salary = $salary;
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

    public function getSalary(): Salary
    {
        return $this->salary;
    }

    public static function fromArray(array $payload): Event
    {
        return new static(
            EventId::fromString($payload['event_id']),
            AggregateRootId::fromString($payload['aggregate_root_id']),
            PersonalData::createFromString(
                $payload['first_name'],
                $payload['last_name'],
                $payload['address']
            ),
            new RemunerationCalculationWay($payload['remuneration_calculation_way']),
            Salary::createFromFloat($payload['salary'])
        );
    }

    public function toArray(): array
    {
        return [
            'event_id' => $this->eventId->toString(),
            'aggregate_root_id' => $this->aggregateRootId->toString(),
            'personal_data' => [
                'first_name' => $this->personalData->getFirstName(),
                'last_name' => $this->personalData->getLastName(),
                'address' => $this->personalData->getAddress(),
            ],
            'remuneration_calculation_way' => $this->remunerationCalculationWay->getValue(),
            'salary' => $this->salary->getAmount(),
        ];
    }
}
