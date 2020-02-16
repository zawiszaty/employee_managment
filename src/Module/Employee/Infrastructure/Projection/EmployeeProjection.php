<?php

declare(strict_types=1);

namespace App\Module\Employee\Infrastructure\Projection;

use App\Infrastructure\Infrastructure\File\FileMoverInterface;
use App\Infrastructure\tests\Infrastructure\Event;
use App\Module\Employee\Domain\Event\EmployeeSalaryReportGeneratedEvent;
use App\Module\Employee\Domain\Event\EmployeeWasCreatedEvent;
use App\Module\Employee\Infrastructure\Generator\PDFGenerator;
use App\Module\Employee\Infrastructure\ReadModel\View\EmployeeView;
use Doctrine\ORM\EntityManagerInterface;

class EmployeeProjection
{
    private PDFGenerator $PDFGenerator;

    private FileMoverInterface $fileMover;

    private EntityManagerInterface $entityManager;

    public function __construct(
        PDFGenerator $PDFGenerator,
        FileMoverInterface $fileMover,
        EntityManagerInterface $entityManager
    ) {
        $this->PDFGenerator = $PDFGenerator;
        $this->fileMover = $fileMover;
        $this->entityManager = $entityManager;
    }

    public function __invoke(Event $event)
    {
        $this->handleEmployeeWasCreatedEvent($event);
    }

    public function handleEmployeeWasCreatedEvent(EmployeeWasCreatedEvent $event): void
    {
        $employee = (new EmployeeView())
            ->setId($event->getAggregateRootId()->getId())
            ->setFirstName($event->getPersonalData()->getFirstName())
            ->setLastName($event->getPersonalData()->getLastName())
            ->setAddress($event->getPersonalData()->getAddress())
            ->setRemunerationCalculationWay($event->getRemunerationCalculationWay())
            ->setSalary($event->getSalary()->getAmount());

        $this->entityManager->persist($employee);
        $this->entityManager->flush();
    }

    public function handleEmployeeSalaryReportGeneratedEvent(EmployeeSalaryReportGeneratedEvent $event): void
    {
//        $reportFileName = $this->PDFGenerator->generateSingleEmployeeReportPDF($event->getHoursAmount(), $event->getSalary()
//            ->getAmount(), $event->getMonth());
//        $this->fileMover->move($reportFileName,);
    }
}
