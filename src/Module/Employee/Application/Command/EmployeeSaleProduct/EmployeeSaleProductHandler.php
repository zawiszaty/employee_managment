<?php

declare(strict_types=1);

namespace App\Module\Employee\Application\Command\EmployeeSaleProduct;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\Clock;
use App\Infrastructure\Domain\CommandHandler;
use App\Infrastructure\Domain\EventDispatcher;
use App\Module\Employee\Domain\EmployeeRepositoryInterface;
use App\Module\Employee\Domain\ValueObject\Commission;

class EmployeeSaleProductHandler extends CommandHandler
{
    private EmployeeRepositoryInterface $employeeRepository;

    private EventDispatcher $eventDispatcher;

    public function __construct(EmployeeRepositoryInterface $employeeRepository, EventDispatcher $eventDispatcher)
    {
        $this->employeeRepository = $employeeRepository;
        $this->eventDispatcher    = $eventDispatcher;
    }

    public function handle(EmployeeSaleProductCommand $command): void
    {
        $employee = $this->employeeRepository->get(AggregateRootId::fromString($command->getEmployeeId()));
        $employee->sale(Commission::create($command->getCollision(), $employee->getId(), Clock::system()));

        $this->employeeRepository->apply($employee);
        $this->employeeRepository->save();

        $this->eventDispatcher->dispatch(...$employee->getUncommittedEvents());
    }
}
