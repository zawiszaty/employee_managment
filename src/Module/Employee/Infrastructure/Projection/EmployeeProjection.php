<?php

declare(strict_types=1);

namespace App\Module\Employee\Infrastructure\Projection;

use App\Infrastructure\Domain\Assertion\Assertion;
use App\Infrastructure\Infrastructure\File\FileMoverInterface;
use App\Infrastructure\tests\Infrastructure\Event;
use App\Module\Employee\Domain\Entity\SalaryReportType;
use App\Module\Employee\Domain\Event\EmployeeSalaryReportForAllEmployeesGeneratedEvent;
use App\Module\Employee\Domain\Event\EmployeeSalaryReportGeneratedEvent;
use App\Module\Employee\Domain\Event\EmployeeWasCreatedEvent;
use App\Module\Employee\Domain\Event\EmployeeWasSaleItemEvent;
use App\Module\Employee\Domain\Event\EmployeeWasWorkedDayEvent;
use App\Module\Employee\Infrastructure\Generator\PDFGenerator;
use App\Module\Employee\Infrastructure\ReadModel\View\EmployeeView;
use App\Module\Employee\Infrastructure\ReadModel\View\SalaryReportView;
use App\Module\Employee\Infrastructure\ReadModel\View\WorkedDayView;
use Doctrine\ORM\EntityManagerInterface;

final class EmployeeProjection
{
    private PDFGenerator $PDFGenerator;

    private FileMoverInterface $fileMover;

    private EntityManagerInterface $entityManager;

    public function __construct(
        PDFGenerator $PDFGenerator,
        FileMoverInterface $fileMover,
        EntityManagerInterface $entityManager
    )
    {
        $this->PDFGenerator  = $PDFGenerator;
        $this->fileMover     = $fileMover;
        $this->entityManager = $entityManager;
        $this->repository    = $this->entityManager->getRepository(EmployeeView::class);
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
            ->setCommissions(0)
            ->setSalary($event->getSalary()->getAmount());

        $this->entityManager->persist($employee);
        $this->entityManager->flush();
    }

    public function handleEmployeeWasSaleItemEvent(EmployeeWasSaleItemEvent $event): void
    {
        $employee = $this->repository->find($event->getAggregateRootId()->getId());

        Assertion::isInstanceOf($employee, EmployeeView::class);
        /** @var EmployeeView $employee */
        $employee->setCommissions($employee->getCommissions() + $event->getCommission()->getCommission());
        $this->entityManager->flush();
    }

    public function handleEmployeeWasWorkedDayEvent(EmployeeWasWorkedDayEvent $event): void
    {
        $employee = $this->repository->find($event->getAggregateId()->getId());

        Assertion::isInstanceOf($employee, EmployeeView::class);
        $workedDay     = $event->getWorkedDay();
        /** @var EmployeeView $employee */
        $workedDayView = (new WorkedDayView())->setEmployee($employee)
            ->setHoursAmount($workedDay->getHoursAmount())
            ->setDay($workedDay->getDay());

        $this->entityManager->persist($workedDayView);
        $this->entityManager->flush();
    }

    public function handleEmployeeSalaryReportGeneratedEvent(EmployeeSalaryReportGeneratedEvent $event): void
    {
        $employee = $this->repository->find($event->getAggregateId()->getId());
        Assertion::isInstanceOf($employee, EmployeeView::class);
        $reportFileName = $this->PDFGenerator->generateSingleEmployeeReportPDF($event->getSalaryReport()
            ->getHoursAmount(), $event->getSalaryReport()->getReward()
            ->getAmount(), (int) $event->getSalaryReport()->getMonth()->currentDateTime()->format('m'));
        $this->fileMover->move($reportFileName);
        /** @var EmployeeView $employee */
        $salaryReportView = (new SalaryReportView())->setEmployee($employee)->setPath($reportFileName)->setType(SalaryReportType::SINGLE_EMPLOYEE());

        $this->entityManager->persist($salaryReportView);
        $this->entityManager->flush();
    }

    public function handleEmployeeSalaryReportForAllEmployeesGeneratedEvent(EmployeeSalaryReportForAllEmployeesGeneratedEvent $event): void
    {
        $reportFileName = $this->PDFGenerator->generateAllEmployeesReportPDF($event->getHoursAmount(), $event->getReward()
            ->getAmount(), (int) $event->getMonth()->currentDateTime()->format('m'), $event->getEmployeeAmounts());
        $this->fileMover->move($reportFileName);

        $salaryReportView = (new SalaryReportView())->setPath($reportFileName)->setType(SalaryReportType::ALL_EMPLOYEE());

        $this->entityManager->persist($salaryReportView);
        $this->entityManager->flush();
    }
}
