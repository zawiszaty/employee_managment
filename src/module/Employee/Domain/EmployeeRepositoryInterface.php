<?php

declare(strict_types=1);

namespace App\module\Employee\Domain;

interface EmployeeRepositoryInterface
{
    public function apply(Employee $aggregateRoot): void;
    public function save(): void;
}