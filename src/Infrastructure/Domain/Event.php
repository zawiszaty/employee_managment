<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain;

/**
 * @codeCoverageIgnore
 */
interface Event
{
    public function toArray(): array;

    public static function fromArray(array $payload): self;
}
