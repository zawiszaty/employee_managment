<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\Event;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\Clock;
use App\Infrastructure\Domain\Event;
use App\Infrastructure\Domain\EventId;
use App\Infrastructure\Domain\Uuid;
use App\Module\Employee\Domain\Entity\SalaryReport;
use App\Module\Employee\Domain\Entity\SalaryReportType;
use App\Module\Employee\Domain\ValueObject\Path;
use App\Module\Employee\Domain\ValueObject\Reward;
use DateTimeImmutable;

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

    public function toArray(): array
    {
        return [
            'event_id'          => $this->id->toString(),
            'aggregate_root_id' => $this->aggregateId->toString(),
            'salary_report'     => [
                'id'           => $this->salaryReport->getId()->toString(),
                'month'        => $this->salaryReport->getMonth()->currentDateTime()->format('d:m:y'),
                'reward'       => $this->salaryReport->getReward(),
                'hours_amount' => $this->salaryReport->getHoursAmount(),
                'salary_type'  => $this->salaryReport->getSalaryReportType()->getValue(),
                'employee_id'  => $this->salaryReport->getEmployeeId(),
                'path'         => $this->salaryReport->getPath()->getValue(),
            ],
        ];
    }

    public static function fromArray(array $payload): Event
    {
        return new static(
            EventId::fromString($payload['event_id']),
            AggregateRootId::fromString($payload['aggregate_root_id']),
            SalaryReport::create(
                Uuid::fromString($payload['salary_report']['id']),
                AggregateRootId::fromString($payload['salary_report']['employee_id']),
                Reward::createFromFloat($payload['reward']),
                Clock::fixed(new DateTimeImmutable($payload['month'])),
                $payload['hours_amount'],
                new SalaryReportType($payload['salary_type']),
                Path::fromString($payload['salary_report']['path'])

            )
        );
    }
}
