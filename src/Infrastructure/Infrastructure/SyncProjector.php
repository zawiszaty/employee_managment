<?php

declare(strict_types=1);


namespace App\Infrastructure\Infrastructure;


use App\Infrastructure\Domain\Event;
use App\Infrastructure\Domain\Projector;
use Psr\Container\ContainerInterface;

final class SyncProjector implements Projector
{
    private ProjectorConfig $config;

    private ContainerInterface $container;

    public function __construct(ProjectorConfig $config, ContainerInterface $container)
    {
        $this->config    = $config;
        $this->container = $container;
    }

    public function project(Event $event): void
    {
        $config     = explode(':', $this->config->getConfig(get_class($event)));
        $projection = $this->container->get($config[0]);
        $projection->{$config[1]}($event);
    }
}