<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain;

use Doctrine\ORM\Mapping as ORM;

/**
 * @method static static generate()
 * @method static static fromString(string $id)
 * @ORM\Embeddable()
 */
final class AggregateRootId extends Uuid
{
}
