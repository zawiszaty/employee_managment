<?php

declare(strict_types=1);

namespace App\Module\Employee\Application\EventHandler\EmployeeSaleProduct;

use App\Infrastructure\Domain\Event;
use App\Infrastructure\Domain\EventPublisher;
use App\Module\Ecommerce\Event\ProductSaleEvent;
use App\Module\Employee\Application\Command\EmployeeSaleProduct\EmployeeSaleProductCommand;
use App\Module\Employee\Application\EmployeeAPIInterface;

final class EmployeeWasSaleItemEventHandler implements EventPublisher
{
    private EmployeeAPIInterface $employeeAPI;

    public function __construct(EmployeeAPIInterface $employeeAPI)
    {
        $this->employeeAPI = $employeeAPI;
    }

    /**
     * @param ProductSaleEvent $event
     */
    public function dispatch(Event $event): void
    {
        $this->employeeAPI->handle(new EmployeeSaleProductCommand(
            $event->getEmployeeId()->toString(),
            $event->getCommission()
        ));
    }

    public function supports(Event $event): bool
    {
        return $event instanceof ProductSaleEvent;
    }
}
