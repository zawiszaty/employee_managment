<?php

declare(strict_types=1);

namespace App\module\Employee\Domain\ValueObject;

use App\Infrastructure\Domain\Assertion\Assertion;

final class PersonalData
{
    private string $firstName;

    private string $lastName;

    private string $address;

    private function __construct(string $firstName, string $lastName, string $address)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address = $address;
    }

    public static function createFromString(string $firstName, string $lastName, string $address): self
    {
        Assertion::notEmpty($firstName);
        Assertion::notEmpty($lastName);
        Assertion::notEmpty($address);

        return new static($firstName, $lastName, $address);
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getAddress(): string
    {
        return $this->address;
    }
}
