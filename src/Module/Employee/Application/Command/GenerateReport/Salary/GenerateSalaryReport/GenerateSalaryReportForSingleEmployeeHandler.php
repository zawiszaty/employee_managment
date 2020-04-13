<?php

declare(strict_types=1);

namespace App\Module\Employee\Application\Command\GenerateReport\Salary\GenerateSalaryReport;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\Clock;
use App\Infrastructure\Domain\CommandHandler;
use App\Infrastructure\Domain\EventDispatcher;
use App\Module\Employee\Domain\EmployeeRepositoryInterface;
use App\Module\Employee\Domain\Policy\CalculateRewardPolicy\CalculateRewardPolicyFactory;
use App\Module\Employee\Domain\ValueObject\Path;
use App\Module\Employee\Domain\WorkedDayRepositoryInterface;
use App\Module\Employee\Infrastructure\Generator\PDFGeneratorInterface;

class GenerateSalaryReportForSingleEmployeeHandler extends CommandHandler
{
    private const NEW_PATH = '/var/www/html/web/private/';

    private EmployeeRepositoryInterface $employeeRepository;

    private CalculateRewardPolicyFactory $calculateRewardPolicyFactory;

    private EventDispatcher $eventDispatcher;

    private PDFGeneratorInterface $PDFGenerator;

    private WorkedDayRepositoryInterface $workedDayRepository;

    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        CalculateRewardPolicyFactory $calculateRewardPolicyFactory,
        EventDispatcher $eventDispatcher,
        PDFGeneratorInterface $PDFGenerator,
        WorkedDayRepositoryInterface $workedDayRepository
    )
    {
        $this->employeeRepository           = $employeeRepository;
        $this->calculateRewardPolicyFactory = $calculateRewardPolicyFactory;
        $this->eventDispatcher              = $eventDispatcher;
        $this->PDFGenerator                 = $PDFGenerator;
        $this->workedDayRepository          = $workedDayRepository;
    }

    public function handle(GenerateSalaryReportForSingleEmployeeCommand $command): void
    {
        $aggregateRootId = AggregateRootId::fromString($command->getEmployeeId());
        $employee        = $this->employeeRepository->get($aggregateRootId);
        $month           = (int) $command->getTime()->format('m');
        $sumWorkedHours  = $this->workedDayRepository->getSumOfEmployeeWorkedHoursByMonth(
            $aggregateRootId,
            $month
        );
        $path            = Path::generate(self::NEW_PATH, 'pdf');
        $employee->generateSalaryReport(
            Clock::fixed($command->getTime()),
            $this->calculateRewardPolicyFactory->getPolicy($employee->getRemunerationCalculationWay()),
            $sumWorkedHours,
            $path
        );
        $this->PDFGenerator->generateSingleEmployeeReportPDF(
            1,
            1.0,
            $month,
            $path->getValue()
        );
        $this->employeeRepository->apply($employee);
        $this->eventDispatcher->dispatch(...$employee->getUncommittedEvents());
    }
}
