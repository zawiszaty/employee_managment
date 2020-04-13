<?php

declare(strict_types=1);

namespace App\Module\Employee\Infrastructure\Repository;

use App\Infrastructure\Domain\AggregateRootId;
use App\Module\Employee\Domain\Entity\WorkedDay;
use App\Module\Employee\Domain\WorkedDayRepositoryInterface;

final class InMemoryWorkedDayReportRepository implements WorkedDayRepositoryInterface
{
    /** @var WorkedDay[] */
    private array $workedDays;

    public function apply(WorkedDay $workedDay): void
    {
        $this->workedDays[] = $workedDay;
    }

    public function getSumOfEmployeeWorkedHoursByMonth(AggregateRootId $aggregateRootId, int $month): int
    {
        $hoursAmount = 0;

        foreach ($this->workedDays as $workedDay) {
            if ($workedDay->getEmployeeId()->toString() === $aggregateRootId->toString()) {
                $hoursAmount += $workedDay->getHoursAmount();
            }
        }

        return $hoursAmount;
    }
}
