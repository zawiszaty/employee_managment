<?php

declare(strict_types=1);

namespace App\module\Employee\tests\Infrastructure\Generator;

use App\module\Employee\Infrastructure\Generator\PDFGenerator;
use Mpdf\Mpdf;
use PHPUnit\Framework\TestCase;

class PDFGeneratorTest extends TestCase
{
    private const TMP_DIR = '/../../../../../../.tmp/';

    private PDFGenerator $PDFGenerator;

    protected function setUp(): void
    {
        $this->PDFGenerator = new PDFGenerator(new Mpdf(['tempDir' => __DIR__.self::TMP_DIR]));
    }

    public function testItGenerateReport(): void
    {
        $filename = $this->PDFGenerator->generateSingleEmployeeReportPDF(10, 2.5, 01);
        $this->assertFileExists(__DIR__.self::TMP_DIR.$filename);
        unlink(__DIR__.self::TMP_DIR.$filename);
    }
}
