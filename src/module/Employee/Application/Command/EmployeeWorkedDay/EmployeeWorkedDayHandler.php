<?php

declare(strict_types=1);

namespace App\module\Employee\Application\Command\EmployeeWorkedDay;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\Clock;
use App\Infrastructure\Domain\CommandHandler;
use App\module\Employee\Domain\Employee;
use App\module\Employee\Domain\EmployeeRepositoryInterface;
use App\module\Employee\Domain\Entity\WorkedDay;

class EmployeeWorkedDayHandler extends CommandHandler
{
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function handle(EmployeeWorkedDayCommand $command): void
    {
        /** @var Employee $employee */
        $employee = $this->employeeRepository->get(AggregateRootId::fromString($command->getEmployeeId()));
        $employee->workedDay(WorkedDay::create($command->getHoursAmount(), Clock::system()));
        $this->employeeRepository->apply($employee);
        $this->employeeRepository->save();
    }
}
