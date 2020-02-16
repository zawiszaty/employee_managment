<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\Infrastructure\Traits;

use App\Module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\Module\Employee\Infrastructure\ReadModel\View\EmployeeView;
use Ramsey\Uuid\Uuid;

trait CreateEmployeeTrait
{
    public function createEmployee(RemunerationCalculationWay $remunerationCalculationWay): EmployeeView
    {
        $employee = (new EmployeeView())
            ->setId(Uuid::uuid4())
            ->setFirstName('test')
            ->setLastName('test')
            ->setAddress('test')
            ->setRemunerationCalculationWay($remunerationCalculationWay)
            ->setCommissions(0)
            ->setSalary(100.0);

        return $employee;
    }
}
