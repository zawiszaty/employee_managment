<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain;

use App\Infrastructure\Domain\AggregateRootId;
use App\Module\Employee\Domain\Entity\WorkedDay;

interface WorkedDayRepositoryInterface
{
    public function apply(WorkedDay $workedDay): void;

    public function getSumOfEmployeeWorkedHoursByMonth(AggregateRootId $aggregateRootId, int $month): int;
}
