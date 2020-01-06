<?php

declare(strict_types=1);

namespace App\Infrastructure\tests;

use App\Infrastructure\Domain\EventId;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * @codeCoverageIgnore
 */
final class EventIdTest extends TestCase
{
    public function testItCreateId()
    {
        $id = EventId::generate();
        $this->assertTrue(Uuid::isValid($id->toString()));
    }
}
