<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\Domain\ValueObject;

use App\Infrastructure\Domain\AssertionException;
use App\Module\Employee\Domain\ValueObject\PersonalData;
use PHPUnit\Framework\TestCase;

/**
 * @codeCoverageIgnore
 */
final class PersonalDataTest extends TestCase
{
    const ADDRESS = 'ul. Jana Z Kolna 11, Gdańsk';
    const FIRST_NAME = 'Jan';
    const LAST_NAME = 'Testowy';

    public function testItCreatePersonalData(): void
    {
        $personalData = PersonalData::createFromString(self::FIRST_NAME, self::LAST_NAME, self::ADDRESS);
        $this->assertSame(self::FIRST_NAME, $personalData->getFirstName());
        $this->assertSame(self::LAST_NAME, $personalData->getLastName());
        $this->assertSame(self::ADDRESS, $personalData->getAddress());
    }

    public function testItThrowExceptionWhenFirstNameIsEmpty(): void
    {
        $this->expectException(AssertionException::class);
        $personalData = PersonalData::createFromString('', self::LAST_NAME, self::ADDRESS);
        $this->assertSame(self::LAST_NAME, $personalData->getLastName());
        $this->assertSame(self::ADDRESS, $personalData->getAddress());
    }
}
