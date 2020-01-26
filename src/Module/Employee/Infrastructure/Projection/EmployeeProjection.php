<?php

declare(strict_types=1);

namespace App\Module\Employee\Infrastructure\Projection;

use App\Infrastructure\Infrastructure\File\FileMoverInterface;
use App\Module\Employee\Domain\Event\EmployeeSalaryReportGeneratedEvent;
use App\Module\Employee\Domain\Event\EmployeeWasCreatedEvent;
use App\Module\Employee\Infrastructure\Generator\PDFGenerator;

class EmployeeProjection
{
    private PDFGenerator $PDFGenerator;

    private FileMoverInterface $fileMover;

    public function __construct(PDFGenerator $PDFGenerator, FileMoverInterface $fileMover)
    {
        $this->PDFGenerator = $PDFGenerator;
        $this->fileMover    = $fileMover;
    }


    public function handleEmployeeWasCreatedEvent(EmployeeWasCreatedEvent $event): void
    {
        throw new \DummyException('test');
    }

    public function handleEmployeeSalaryReportGeneratedEvent(EmployeeSalaryReportGeneratedEvent $event): void
    {
//        $reportFileName = $this->PDFGenerator->generateSingleEmployeeReportPDF($event->getHoursAmount(), $event->getSalary()
//            ->getAmount(), $event->getMonth());
//        $this->fileMover->move($reportFileName,);
    }
}
