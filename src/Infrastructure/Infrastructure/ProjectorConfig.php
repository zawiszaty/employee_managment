<?php

declare(strict_types=1);

namespace App\Infrastructure\Infrastructure;

use App\Module\Employee\Domain\Event\EmployeeWasCreatedEvent;
use App\Module\Employee\Infrastructure\Projection\EmployeeProjection;

class ProjectorConfig
{
    private array $config;

    public function __construct()
    {
        $this->config = [
            EmployeeWasCreatedEvent::class => EmployeeProjection::class.':handleEmployeeWasCreatedEvent',
        ];
    }

    public function getConfig(string $key): string
    {
        return $this->config[$key];
    }
}
