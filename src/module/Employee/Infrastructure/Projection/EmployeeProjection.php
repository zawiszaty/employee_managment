<?php

declare(strict_types=1);

namespace App\module\Employee\Infrastructure\Projection;

use App\Infrastructure\Infrastructure\File\FileMoverInterface;
use App\module\Employee\Domain\Event\EmployeeSalaryReportGeneratedEvent;
use App\module\Employee\Infrastructure\Generator\PDFGenerator;

class EmployeeProjection
{
    private PDFGenerator $PDFGenerator;

    private FileMoverInterface $fileMover;

    public function __construct(PDFGenerator $PDFGenerator, FileMoverInterface $fileMover)
    {
        $this->PDFGenerator = $PDFGenerator;
        $this->fileMover = $fileMover;
    }

    public function handleEmployeeSalaryReportGeneratedEvent(EmployeeSalaryReportGeneratedEvent $event): void
    {
        $reportFileName = $this->PDFGenerator->generateSingleEmployeeReportPDF($event->getHoursAmount(), $event->getSalary()->getAmount(), $event->getMonth());
        $this->fileMover->move($reportFileName, );
    }
}
