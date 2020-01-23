<?php

declare(strict_types=1);

namespace App\Module\Employee\Application\Command\GenerateReport\Salary\GenerateForAllEmployees;

use App\Infrastructure\Domain\CommandHandler;
use App\Infrastructure\Domain\EventDispatcher;
use App\Module\Employee\Domain\Entity\SalaryReport;
use App\Module\Employee\Domain\Event\EmployeeSalaryReportForAllEmployeesGeneratedEvent;
use App\Module\Employee\Domain\SalaryReportRepositoryInterface;
use App\Module\Employee\Domain\ValueObject\Reward;

class GenerateForAllEmployeesHandler extends CommandHandler
{
    private SalaryReportRepositoryInterface $salaryReportRepository;

    private EventDispatcher $eventDispatcher;

    public function __construct(SalaryReportRepositoryInterface $salaryReportRepository, EventDispatcher $eventDispatcher)
    {
        $this->salaryReportRepository = $salaryReportRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(GenerateForAllEmployeesCommand $command): void
    {
        $reports = $this->salaryReportRepository->getByMonth($command->getMonth());
        $reward = 0.0;
        $employeesAmount = 0;
        $hoursAmount = 0;

        /** @var SalaryReport $report */
        foreach ($reports as $report) {
            $reward += $report->getReward()->getAmount();
            ++$employeesAmount;
            $hoursAmount += $report->getHoursAmount();
        }
        $this->eventDispatcher->dispatch(new EmployeeSalaryReportForAllEmployeesGeneratedEvent(
            Reward::createFromFloat((float) $reward),
            $command->getMonth(),
            $employeesAmount,
            $hoursAmount
        ));
    }
}
