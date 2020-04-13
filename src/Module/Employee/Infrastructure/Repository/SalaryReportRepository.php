<?php

declare(strict_types=1);

namespace App\Module\Employee\Infrastructure\Repository;

use App\Infrastructure\Domain\Clock;
use App\Infrastructure\Domain\Uuid;
use App\Infrastructure\Infrastructure\Doctrine\MysqlRepository;
use App\Module\Employee\Domain\Employee;
use App\Module\Employee\Domain\Entity\SalaryReport;
use App\Module\Employee\Domain\SalaryReportRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class SalaryReportRepository extends MysqlRepository implements SalaryReportRepositoryInterface
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->class = SalaryReport::class;
        parent::__construct($entityManager);
    }

    public function get(Uuid $id): SalaryReport
    {
        $employee = $this->repository->find($id->toString());

        if (false === $employee instanceof Employee)
        {
            throw new \DomainException('Employee Not Found');
        }

        /** @var SalaryReport $employee */
        return $employee;
    }

    public function getByMonth(Clock $month): array
    {
        return $this->repository->findBy([
            'month' => $month->currentDateTime()->format('m')
        ]);
    }

    public function apply(SalaryReport $salaryReport): void
    {
        $this->register($salaryReport);
    }
}
