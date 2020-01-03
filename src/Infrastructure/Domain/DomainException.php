<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain;

use Assert\InvalidArgumentException;

final class DomainException extends InvalidArgumentException
{
}