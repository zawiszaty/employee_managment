<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\ValueObject;

use App\Infrastructure\Domain\Uuid;

final class Path
{
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function generate(string $path, string $extension): self
    {
        return new self(sprintf('%s%s.%s', $path, Uuid::generate()->toString(), $extension));
    }

    public static function fromString(string $path): self
    {
        return new self($path);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
