<?php

declare(strict_types=1);

namespace App\Infrastructure\Tests;

use App\Infrastructure\Domain\AggregateRootId;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * @codeCoverageIgnore
 */
final class AggregateRootIdTest extends TestCase
{
    public function testItCreateId()
    {
        $id = AggregateRootId::generate();
        $this->assertTrue(Uuid::isValid($id->toString()));
    }
}
