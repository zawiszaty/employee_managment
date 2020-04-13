<?php

declare(strict_types=1);

namespace App\Module\Employee\Infrastructure\Repository;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Infrastructure\Doctrine\MysqlRepository;
use App\Module\Employee\Domain\Employee;
use App\Module\Employee\Domain\EmployeeRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class EmployeeRepository extends MysqlRepository implements EmployeeRepositoryInterface
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->class = Employee::class;
        parent::__construct($entityManager);
    }

    public function apply(Employee $employee): void
    {
        $this->register($employee);
    }

    public function get(AggregateRootId $aggregateRootId): Employee
    {
        $employee = $this->repository->find($aggregateRootId->toString());

        if (false === $employee instanceof Employee) {
            throw new \DomainException('Employee Not Found');
        }

        /* @var Employee $employee */
        return $employee;
    }
}
