<?php

declare(strict_types=1);

namespace App\Module\Employee\Infrastructure\Repository;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Infrastructure\InMemoryAggregateRepository;
use App\Module\Employee\Domain\Employee;
use App\Module\Employee\Domain\EmployeeRepositoryInterface;

final class InMemoryEmployeeAggregateRepository extends InMemoryAggregateRepository implements EmployeeRepositoryInterface
{
    public function get(AggregateRootId $aggregateRootId): Employee
    {
        return parent::get($aggregateRootId);
    }
}
