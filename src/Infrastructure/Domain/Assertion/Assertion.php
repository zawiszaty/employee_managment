<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Assertion;

use Assert\Assertion as BaseAssertion;

/**
 * @codeCoverageIgnore
 */
final class Assertion extends BaseAssertion
{
    protected static $exceptionClass = 'App\Infrastructure\Domain\DomainException';
}