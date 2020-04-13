<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\Functional\EventHandler;

use App\Infrastructure\Domain\EventDispatcher;
use App\Infrastructure\Domain\EventId;
use App\Module\Ecommerce\Event\ProductSaleEvent;
use App\Module\Employee\Domain\Employee;
use App\Module\Employee\Domain\ValueObject\Commission;
use App\Module\Employee\Tests\TestDouble\ApplicationFunctionalTestCase;
use App\Module\Employee\Tests\TestDouble\EmployeeMother;

final class EmployeeWasSaleItemEventHandlerTest extends ApplicationFunctionalTestCase
{
    private EventDispatcher $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = self::$container->get(EventDispatcher::class);
    }

    /**
     * @test
     */
    public function whenEventHandleSuccessful(): void
    {
        $employee = EmployeeMother::createEmployeeMC();
        $this->entityManager->persist($employee);
        $this->entityManager->flush();
        /** @var Employee $employee */
        $employee = $this->entityManager->getRepository(Employee::class)->findOneBy([]);

        $this->handler->dispatch(new ProductSaleEvent(
            EventId::generate(),
            $employee->getId(),
            200.0
        ));

        $commissions = $this->entityManager->getRepository(Commission::class)->findBy([
            'employeeId' => $employee->getId()->toString(),
        ]);
        $this->assertGreaterThan(0, count($commissions));
    }
}
