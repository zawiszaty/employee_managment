<?php

declare(strict_types=1);

namespace App\Module\Employee\Application\Command\GenerateReport\Salary\GenerateForAllEmployees;

use App\Infrastructure\Domain\CommandHandler;
use App\Infrastructure\Domain\EventDispatcher;
use App\Infrastructure\Domain\EventId;
use App\Infrastructure\Domain\Uuid;
use App\Module\Employee\Domain\Entity\SalaryReport;
use App\Module\Employee\Domain\Entity\SalaryReportType;
use App\Module\Employee\Domain\Event\EmployeeSalaryReportForAllEmployeesGeneratedEvent;
use App\Module\Employee\Domain\SalaryReportRepositoryInterface;
use App\Module\Employee\Domain\ValueObject\Path;
use App\Module\Employee\Domain\ValueObject\Reward;
use App\Module\Employee\Infrastructure\Generator\PDFGeneratorInterface;

class GenerateForAllEmployeesHandler extends CommandHandler
{
    private const NEW_PATH = '/var/www/html/web/private/';

    private SalaryReportRepositoryInterface $salaryReportRepository;

    private EventDispatcher $eventDispatcher;

    private PDFGeneratorInterface $PDFGenerator;

    public function __construct(
        SalaryReportRepositoryInterface $salaryReportRepository,
        EventDispatcher $eventDispatcher,
        PDFGeneratorInterface $PDFGenerator
    )
    {
        $this->salaryReportRepository = $salaryReportRepository;
        $this->eventDispatcher        = $eventDispatcher;
        $this->PDFGenerator           = $PDFGenerator;
    }

    public function handle(GenerateForAllEmployeesCommand $command): void
    {
        $reports         = $this->salaryReportRepository->getByMonth($command->getMonth());
        $reward          = 0.0;
        $employeesAmount = 0;
        $hoursAmount     = 0;
        $path            = Path::generate(self::NEW_PATH, 'pdf');
        $month           = (int) $command->getMonth()->currentDateTime()->format('m');

        foreach ($reports as $report)
        {
            $reward += $report->getReward()->getAmount();
            ++$employeesAmount;
            $hoursAmount += $report->getHoursAmount();
        }
        $salaryReport = SalaryReport::create(
            Uuid::generate(),
            null,
            Reward::createFromFloat($reward),
            $command->getMonth(),
            $hoursAmount,
            SalaryReportType::ALL_EMPLOYEE(),
            $path
        );
        $this->PDFGenerator->generateAllEmployeesReportPDF(
            $hoursAmount,
            $reward,
            $month,
            $employeesAmount,
            $path->getValue()
        );
        $this->salaryReportRepository->apply($salaryReport);
        $this->eventDispatcher->dispatch(new EmployeeSalaryReportForAllEmployeesGeneratedEvent(
            EventId::generate(),
            Reward::createFromFloat($reward),
            $command->getMonth(),
            $employeesAmount,
            $hoursAmount
        ));
    }
}
