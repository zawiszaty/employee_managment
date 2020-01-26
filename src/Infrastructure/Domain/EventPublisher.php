<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain;

interface EventPublisher
{
    public function dispatch(Event $event): void;

    public function supports(Event $event): bool;
}
