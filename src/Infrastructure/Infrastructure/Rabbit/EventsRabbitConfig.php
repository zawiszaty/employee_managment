<?php

declare(strict_types=1);

namespace App\Infrastructure\Infrastructure\Rabbit;

use App\Module\Ecommerce\Event\ProductSaleEvent;
use App\Module\Employee\Domain\Event\EmployeeWasWorkedDayEvent;

final class EventsRabbitConfig
{
    /** @var string[] */
    private array $events;

    public function __construct()
    {
        $this->events = [
            ProductSaleEvent::class => 'employee.sale.item',
            EmployeeWasWorkedDayEvent::class => 'employee.worked.day',
        ];
    }

    public function hasByNamespace(string $index): bool
    {
        return array_key_exists($index, $this->events);
    }

    public function hasByRoutingKey(string $routingKey): bool
    {
        $flippedEvents = array_flip($this->events);

        return array_key_exists($routingKey, $flippedEvents);
    }

    public function getByNamespace(string $index): string
    {
        return $this->events[$index];
    }

    public function getByRoutingKey(string $routingKey): string
    {
        $flippedEvents = array_flip($this->events);

        return $flippedEvents[$routingKey];
    }
}
