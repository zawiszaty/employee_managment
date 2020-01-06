<?php

declare(strict_types=1);

namespace App\module\Employee\Domain;

use App\Infrastructure\Domain\AggregateRoot;
use App\Infrastructure\Domain\AggregateRootId;

interface EmployeeRepositoryInterface
{
    public function apply(Employee $aggregateRoot): void;

    public function get(AggregateRootId $aggregateRootId): AggregateRoot;

    public function save(): void;
}
