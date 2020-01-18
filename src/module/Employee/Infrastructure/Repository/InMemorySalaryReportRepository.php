<?php

declare(strict_types=1);

namespace App\module\Employee\Infrastructure\Repository;

use App\Infrastructure\Domain\Uuid;
use App\Infrastructure\Infrastructure\InMemoryRepository;
use App\module\Employee\Domain\Entity\SalaryReport;
use App\module\Employee\Domain\SalaryReportRepositoryInterface;

final class InMemorySalaryReportRepository extends InMemoryRepository implements SalaryReportRepositoryInterface
{
    public function get(Uuid $aggregateRootId): SalaryReport
    {
        return parent::get($aggregateRootId);
    }

    public function getByMonth(int $month): array
    {
        $reports = [];

        /** @var SalaryReport $aggregate */
        foreach ($this->aggregates as $aggregate) {
            if ($aggregate->getMonth() === $month) {
                $reports[] = $aggregate;
            }
        }

        return $reports;
    }
}
