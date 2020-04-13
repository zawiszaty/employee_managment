<?php

declare(strict_types=1);

namespace App\Infrastructure\Infrastructure\Doctrine\CustomTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ramsey\Uuid\Doctrine\UuidType;

final class Uuid extends UuidType
{
    public const NAME = 'uuid_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): \App\Infrastructure\Domain\Uuid
    {
        return \App\Infrastructure\Domain\Uuid::fromString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
