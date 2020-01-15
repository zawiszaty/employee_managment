<?php

declare(strict_types=1);


namespace App\Infrastructure\Infrastructure\File;


class FileMover implements FileMoverInterface
{
    public function move(string $filename, string $oldPath, string $newPath): void
    {
        copy($oldPath . $filename, $newPath . $filename);
        unlink($oldPath . $filename);
    }
}