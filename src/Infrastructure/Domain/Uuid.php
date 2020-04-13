<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain;

use App\Infrastructure\Domain\Assertion\Assertion;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @codeCoverageIgnore
 */
class Uuid
{
    private UuidInterface $id;

    private function __construct()
    {
    }

    public static function generate(): self
    {
        $id     = new static();
        $id->id = RamseyUuid::uuid4();

        return $id;
    }

    public static function fromString(string $uuid): self
    {
        Assertion::uuid($uuid);
        $id = new static();
        $id->id = RamseyUuid::fromString($uuid);

        return $id;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function toString(): string
    {
        return $this->__toString();
    }

    public function __toString()
    {
        return $this->id->toString();
    }
}
