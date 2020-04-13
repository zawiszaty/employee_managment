<?php

declare(strict_types=1);

namespace App\Module\Employee\Application\Command\EmployeeWorkedDay;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\Clock;
use App\Infrastructure\Domain\CommandHandler;
use App\Infrastructure\Domain\EventDispatcher;
use App\Module\Employee\Domain\Employee;
use App\Module\Employee\Domain\EmployeeRepositoryInterface;
use App\Module\Employee\Domain\Entity\WorkedDay;

class EmployeeWorkedDayHandler extends CommandHandler
{
    private EmployeeRepositoryInterface $employeeRepository;

    private EventDispatcher $eventDispatcher;

    public function __construct(EmployeeRepositoryInterface $employeeRepository, EventDispatcher $eventDispatcher)
    {
        $this->employeeRepository = $employeeRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(EmployeeWorkedDayCommand $command): void
    {
        /** @var Employee $employee */
        $employee = $this->employeeRepository->get(AggregateRootId::fromString($command->getEmployeeId()));
        $employee->workedDay(WorkedDay::create($command->getHoursAmount(), Clock::system(), $employee->getId()));

        $this->employeeRepository->apply($employee);
        $this->employeeRepository->save();

        $this->eventDispatcher->dispatch(...$employee->getUncommittedEvents());
    }
}
