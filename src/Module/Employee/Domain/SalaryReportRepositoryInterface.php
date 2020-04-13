<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain;

use App\Infrastructure\Domain\Clock;
use App\Infrastructure\Domain\Uuid;
use App\Module\Employee\Domain\Entity\SalaryReport;

interface SalaryReportRepositoryInterface
{
    public function apply(SalaryReport $salaryReport): void;

    public function get(Uuid $aggregateRootId): SalaryReport;

    /** @return SalaryReport[] */
    public function getByMonth(Clock $month): array;

    public function save(): void;
}
