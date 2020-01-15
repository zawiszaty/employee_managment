<?php

declare(strict_types=1);

namespace App\module\Employee\Infrastructure\Projection;

use App\module\Employee\Domain\Event\EmployeeSalaryReportGeneratedEvent;
use App\module\Employee\Infrastructure\Generator\PDFGenerator;

class EmployeeProjection
{
    private PDFGenerator $PDFGenerator;

    public function __construct(PDFGenerator $PDFGenerator)
    {
        $this->PDFGenerator = $PDFGenerator;
    }

    public function handleEmployeeSalaryReportGeneratedEvent(EmployeeSalaryReportGeneratedEvent $event): void
    {
        $reportFileName = $this->PDFGenerator->generateSingleEmployeeReportPDF($event->getHoursAmount(), $event->getSalary()->getAmount(), $event->getMonth());
    }
}
