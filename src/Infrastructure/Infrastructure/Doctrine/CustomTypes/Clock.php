<?php

declare(strict_types=1);

namespace App\Infrastructure\Infrastructure\Doctrine\CustomTypes;

use DateTimeImmutable;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeType;

final class Clock extends DateTimeType
{
    public function convertToPHPValue($value, AbstractPlatform $platform): \App\Infrastructure\Domain\Clock
    {
        $datetime = new DateTimeImmutable($value);

        return \App\Infrastructure\Domain\Clock::fixed($datetime);
    }

    /**
     * @param \App\Infrastructure\Domain\Clock $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (false === $value instanceof \App\Infrastructure\Domain\Clock) {
            throw new \Exception('Must be instanceof clock');
        }

        return $value->currentDateTime()->format($platform->getDateTimeFormatString());
    }
}
