<?php

declare(strict_types=1);

namespace App\module\Employee\tests\Application\Command\CreateEmployee;

use App\Infrastructure\Infrastructure\InMemoryEventDispatcher;
use App\module\Employee\Application\Command\CreateEmployee\CreateEmployeeCommand;
use App\module\Employee\Application\Command\CreateEmployee\CreateEmployeeHandler;
use App\module\Employee\Application\EmployeeApi;
use App\module\Employee\Domain\Event\EmployeeWasCreatedEvent;
use App\module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use App\module\Employee\Infrastructure\Repository\InMemoryEmployeeAggregateRepository;
use PHPUnit\Framework\TestCase;

/**
 * @codeCoverageIgnore
 */
final class CreateEmployeeHandlerTest extends TestCase
{
    private InMemoryEventDispatcher $eventDispatcher;

    private EmployeeApi $api;

    public function testItCreateEmployee(): void
    {
        $this->api->handle(new CreateEmployeeCommand('test', 'test', 'test', 'hourly', 2.5));
        $events = $this->eventDispatcher->getEvents();
        $this->assertCount(1, $events);
        /** @var EmployeeWasCreatedEvent $event */
        $event = $events[0];
        $this->assertInstanceOf(EmployeeWasCreatedEvent::class, $event);
        $this->assertTrue($event->getRemunerationCalculationWay()->equals(RemunerationCalculationWay::HOURLY()));
        $this->assertSame($event->getPersonalData()->getAddress(), 'test');
        $this->assertSame($event->getPersonalData()->getFirstName(), 'test');
        $this->assertSame($event->getPersonalData()->getLastName(), 'test');
    }

    protected function setUp(): void
    {
        $this->eventDispatcher = new InMemoryEventDispatcher();
        $createEmployeeHandler = new CreateEmployeeHandler(new InMemoryEmployeeAggregateRepository($this->eventDispatcher));
        $this->api = new EmployeeApi();
        $this->api->addHandler($createEmployeeHandler);
    }
}
