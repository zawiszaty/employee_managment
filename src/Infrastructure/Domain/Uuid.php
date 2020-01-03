<?php

declare(strict_types=1);


namespace App\Infrastructure\Domain;

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

    public function toString(): string
    {
        return $this->id;
    }
}