<?php

declare(strict_types=1);

namespace App\Infrastructure\Application;

use App\Infrastructure\Domain\CommandHandler;
use App\Infrastructure\Domain\DomainException;

class CommandBus
{
    /** @var array<CommandHandler> */
    private array $commandsHandlers = [];

    public function addHandler(CommandHandler $commandHandler): void
    {
        $this->commandsHandlers[\get_class($commandHandler)] = $commandHandler;
    }

    public function handle(object $command): void
    {
        $handler = $this->commandToHandler(\get_class($command));
        $handler->handle($command);
    }

    private function commandToHandler(string $command): CommandHandler
    {
        $commandHandler = explode('\\', $command);
        $commandHandler[count($commandHandler) - 1] = str_replace('Command', 'Handler', $commandHandler[count($commandHandler) - 1]);
        $commandHandler = implode('\\', $commandHandler);

        if (false === array_key_exists($commandHandler, $this->commandsHandlers)) {
            throw new DomainException('Handler not Found');
        }
        $handler = $this->commandsHandlers[$commandHandler];

        if (!$handler instanceof CommandHandler) {
            throw new DomainException('Handler not Found');
        }

        return $handler;
    }
}
