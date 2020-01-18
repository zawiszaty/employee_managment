<?php

declare(strict_types=1);


namespace App\module\Employee\Domain;


use App\Infrastructure\Domain\AggregateRootId;
use App\module\Employee\Domain\Entity\SalaryReport;

interface SalaryReportRepositoryInterface
{
    public function apply(SalaryReport $aggregateRoot): void;

    public function get(AggregateRootId $aggregateRootId): SalaryReport;

    public function getByMonth(int $month): array;

    public function save(): void;
}