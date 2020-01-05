<?php

declare(strict_types=1);

namespace App\module\Employee\Infrastructure\Repository;

use App\Infrastructure\Infrastructure\InMemoryRepository;
use App\module\Employee\Domain\EmployeeRepositoryInterface;

final class InMemoryEmployeeRepository extends InMemoryRepository implements EmployeeRepositoryInterface
{
}
