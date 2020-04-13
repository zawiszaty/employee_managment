<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\Event;

use App\Infrastructure\Domain\Clock;
use App\Infrastructure\Domain\Event;
use App\Infrastructure\Domain\EventId;
use App\Module\Employee\Domain\ValueObject\Reward;
use DateTimeImmutable;

/**
 * @codeCoverageIgnore
 */
class EmployeeSalaryReportForAllEmployeesGeneratedEvent implements Event
{
    private EventId $id;

    private Reward $reward;

    private Clock $month;

    private int $employeeAmounts;

    private int $hoursAmount;

    public function __construct(EventId $eventId, Reward $reward, Clock $month, int $employeeAmounts, int $hoursAmount)
    {
        $this->id              = $eventId;
        $this->reward          = $reward;
        $this->month           = $month;
        $this->employeeAmounts = $employeeAmounts;
        $this->hoursAmount     = $hoursAmount;
    }

    public function getId(): EventId
    {
        return $this->id;
    }

    public function getReward(): Reward
    {
        return $this->reward;
    }

    public function getMonth(): Clock
    {
        return $this->month;
    }

    public function getEmployeeAmounts(): int
    {
        return $this->employeeAmounts;
    }

    public function getHoursAmount(): int
    {
        return $this->hoursAmount;
    }

    public function toArray(): array
    {
        return [
            'event_id'         => $this->id->toString(),
            'reward'           => $this->reward->getAmount(),
            'month'            => $this->month->currentDateTime()->format('m'),
            'employee_amounts' => $this->employeeAmounts,
            'hours_amount'     => $this->getHoursAmount(),
        ];
    }

    public static function fromArray(array $payload): Event
    {
        return new static(
            EventId::fromString($payload['event']),
            Reward::createFromFloat($payload['reward']),
            Clock::fixed(new DateTimeImmutable($payload['month'])),
            $payload['employee_amounts'],
            $payload['hours_amount']
        );
    }
}
