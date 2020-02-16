<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\ValueObject;

use App\Infrastructure\Domain\Clock;
use App\Module\Employee\Domain\Entity\WorkedDay;

final class WorkedDaysCollection
{
    /** @var array<WorkedDay> */
    private array $workedDays = [];

    public function push(WorkedDay $workedDay): void
    {
        $this->workedDays[] = $workedDay;
    }

    public function getAll(): array
    {
        return $this->workedDays;
    }

    public function sumHoursAmount(Clock $month): int
    {
        $workedHours = 0;

        array_map(static function (WorkedDay $workedDay) use (&$workedHours, $month) {
            if ((int) $workedDay->getDay()->format('m') === (int) $month->currentDateTime()->format('m')) {
                $workedHours += $workedDay->getHoursAmount();
            }
        }, $this->workedDays);

        return $workedHours;
    }
}
