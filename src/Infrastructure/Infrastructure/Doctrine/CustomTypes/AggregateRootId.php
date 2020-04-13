<?php

declare(strict_types=1);

namespace App\Infrastructure\Infrastructure\Doctrine\CustomTypes;

use App\Infrastructure\Domain\AggregateRootId as AggregateRootIdAlias;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ramsey\Uuid\Doctrine\UuidType;

final class AggregateRootId extends UuidType
{
    public const NAME = 'aggregate_root_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): AggregateRootIdAlias
    {
        return AggregateRootIdAlias::fromString($value);
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