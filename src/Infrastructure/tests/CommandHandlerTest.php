<?php

declare(strict_types=1);

namespace App\Infrastructure\tests;

use App\Infrastructure\Application\CommandBus;
use App\Infrastructure\Domain\CommandHandler;
use App\Infrastructure\Domain\DomainException;
use PHPUnit\Framework\TestCase;

final class TestCommandBus extends CommandBus
{

}

final class TestCommand
{

}

final class TestHandler extends CommandHandler
{
    private int $id = 0;

    public function handle(TestCommand $command): void
    {
        $this->id++;
    }

    public function getId(): int
    {
        return $this->id;
    }
}

final class CommandHandlerTest extends TestCase
{
    public function testItHandleCommand(): void
    {
        $commandBus = new TestCommandBus();
        $handler = new TestHandler();
        $commandBus->addHandler($handler);
        $commandBus->handle(new TestCommand());
        $this->assertSame(1, $handler->getId());
    }

    public function testItThrowExceptionWhenMissingHandler(): void
    {
        $this->expectException(DomainException::class);
        $commandBus = new TestCommandBus();
        $commandBus->handle(new TestCommand());
    }
}
    