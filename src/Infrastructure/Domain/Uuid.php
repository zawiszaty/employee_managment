<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain;

use App\Infrastructure\Domain\Assertion\Assertion;

/**
 * @codeCoverageIgnore
 */
class Uuid
{
    private string $id;

    private function __construct()
    {
    }

    public static function generate(): self
    {
        $id = new static();
        $id->id = \Ramsey\Uuid\Uuid::uuid4()->toString();

        return $id;
    }

    public static function fromString(string $uuid): self
    {
        Assertion::uuid($uuid);
        $id = new static();
        $id->id = $uuid;

        return $id;
    }

    public function toString(): string
    {
        return $this->id;
    }
}
