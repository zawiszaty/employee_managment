<?php

declare(strict_types=1);

namespace App\Infrastructure\Infrastructure\File;

class FileMover implements FileMoverInterface
{
    private const OLD_PATH = __DIR__ . '/../../../../.tmp/';

    private const NEW_PATH = __DIR__ . '/../../../../web/private/';

    public function move(string $filename): void
    {
        copy(self::OLD_PATH . $filename, self::NEW_PATH . $filename);
        unlink(self::OLD_PATH . $filename);
    }
}
