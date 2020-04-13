<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain;

use App\Infrastructure\Domain\AggregateRootId;

interface EmployeeRepositoryInterface
{
    public function apply(Employee $aggregateRoot): void;

    public function get(AggregateRootId $aggregateRootId): Employee;

    public function save(): void;
}
