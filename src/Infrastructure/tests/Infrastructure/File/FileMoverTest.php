<?php

declare(strict_types=1);

namespace App\Infrastructure\tests\Infrastructure\File;

use App\Infrastructure\Infrastructure\File\FileMover;
use PHPUnit\Framework\TestCase;

class FileMoverTest extends TestCase
{
    private FileMover $mover;

    protected function setUp(): void
    {
        $this->mover = new FileMover();
        file_put_contents(__DIR__.'/../../../../../.tmp/test.txt', 'test');
    }

    public function testItMoveFileToOtherDir(): void
    {
        $this->mover->move('test.txt');
        $this->assertFileNotExists(__DIR__.'/../../../../../.tmp/test.txt');
        $this->assertFileExists(__DIR__.'/../../../../../web/private/test.txt');
        unlink(__DIR__.'/../../../../../web/private/test.txt');
    }
}
