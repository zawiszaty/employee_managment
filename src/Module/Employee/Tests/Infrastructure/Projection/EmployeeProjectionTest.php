<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\Infrastructure\Projection;

use App\Infrastructure\Domain\AggregateRootId;
use App\Module\Employee\Domain\Event\EmployeeWasCreatedEvent;
use App\Module\Employee\Domain\ValueObject\PersonalData;
use App\Module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\Module\Employee\Domain\ValueObject\Salary;
use App\Module\Employee\Infrastructure\Projection\EmployeeProjection;
use App\Module\Employee\Infrastructure\ReadModel\View\EmployeeView;
use App\Module\Employee\Tests\Infrastructure\InfrastructureTestCase;

final class EmployeeProjectionTest extends InfrastructureTestCase
{
    private EmployeeProjection $projection;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository|\Doctrine\Persistence\ObjectRepository
     */
    private $employeeRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->projection = self::$container->get(EmployeeProjection::class);
        $this->employeeRepository = $this->entityManager->getRepository(EmployeeView::class);
    }

    public function testItCreateEmployeeInDB(): void
    {
        self::assertCount(0, $this->employeeRepository->findAll());
        $this->projection->handleEmployeeWasCreatedEvent(
            new EmployeeWasCreatedEvent(
                AggregateRootId::generate(),
                PersonalData::createFromString('test', 'test', 'test'),
                RemunerationCalculationWay::HOURLY(),
                Salary::createFromFloat(20.0),
            )
        );
        self::assertCount(1, $this->employeeRepository->findAll());
    }
}
