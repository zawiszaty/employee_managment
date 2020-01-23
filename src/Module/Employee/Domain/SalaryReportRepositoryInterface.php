<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain;

use App\Infrastructure\Domain\AggregateRootId;
use App\Module\Employee\Domain\Entity\SalaryReport;

interface SalaryReportRepositoryInterface
{
    public function apply(SalaryReport $aggregateRoot): void;

    public function get(AggregateRootId $aggregateRootId): SalaryReport;

    public function getByMonth(int $month): array;

    public function save(): void;
}
