<?php

declare(strict_types=1);

namespace App\Module\Employee\Infrastructure\Repository;

use App\Infrastructure\Domain\Clock;
use App\Infrastructure\Domain\Uuid;
use App\Infrastructure\Infrastructure\InMemoryRepository;
use App\Module\Employee\Domain\Entity\SalaryReport;
use App\Module\Employee\Domain\SalaryReportRepositoryInterface;

final class InMemorySalaryReportRepository extends InMemoryRepository implements SalaryReportRepositoryInterface
{
    public function get(Uuid $aggregateRootId): SalaryReport
    {
        return parent::get($aggregateRootId);
    }

    public function getByMonth(Clock $month): array
    {
        $reports = [];

        /** @var SalaryReport $aggregate */
        foreach ($this->aggregates as $aggregate) {
            if ($aggregate->getMonth()->currentDateTime()->format('m') === $month->currentDateTime()->format('m')) {
                $reports[] = $aggregate;
            }
        }

        return $reports;
    }
}
