<?php

declare(strict_types=1);

namespace App\Module\Employee\Infrastructure\Repository;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Infrastructure\Doctrine\MysqlRepository;
use App\Module\Employee\Domain\Entity\WorkedDay;
use App\Module\Employee\Domain\WorkedDayRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class WorkedDayRepository extends MysqlRepository implements WorkedDayRepositoryInterface
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->class = WorkedDay::class;
        parent::__construct($entityManager);
    }

    public function apply(WorkedDay $workedDay): void
    {
        $this->register($workedDay);
    }

    public function getSumOfEmployeeWorkedHoursByMonth(AggregateRootId $aggregateRootId, int $month): int
    {
        return (int) $this->repository->createQueryBuilder('w')
            ->select('SUM(w.hoursAmount)')
            ->where('DATE_PART(:type,w.day) = :month')
            ->andWhere('w.employeeId = :id')
            ->setParameter('month', $month)
            ->setParameter('type', 'month')
            ->setParameter('id', $aggregateRootId->toString())
            ->getQuery()
            ->getSingleScalarResult();
    }
}
