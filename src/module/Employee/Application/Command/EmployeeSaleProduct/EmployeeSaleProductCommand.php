<?php

declare(strict_types=1);

namespace App\module\Employee\Application\Command\EmployeeSaleProduct;

class EmployeeSaleProductCommand
{
    private string $employeeId;

    private float $collision;

    public function __construct(
        string $employeeId,
        float $collision
    ) {
        $this->employeeId = $employeeId;
        $this->collision = $collision;
    }

    public function getEmployeeId(): string
    {
        return $this->employeeId;
    }

    public function getCollision(): float
    {
        return $this->collision;
    }
}
