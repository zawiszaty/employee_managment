<?php

declare(strict_types=1);

namespace App\module\Employee\Infrastructure\Repository;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Infrastructure\InMemoryAggregateRepository;
use App\module\Employee\Domain\Employee;
use App\module\Employee\Domain\EmployeeRepositoryInterface;

final class InMemoryEmployeeAggregateRepository extends InMemoryAggregateRepository implements EmployeeRepositoryInterface
{
    public function get(AggregateRootId $aggregateRootId): Employee
    {
        return parent::get($aggregateRootId);
    }
}
