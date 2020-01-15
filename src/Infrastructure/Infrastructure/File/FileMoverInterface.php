<?php

declare(strict_types=1);


namespace App\Infrastructure\Infrastructure\File;


interface FileMoverInterface
{
    public function move(string $filename, string $oldPath, string $newPath): void;
}