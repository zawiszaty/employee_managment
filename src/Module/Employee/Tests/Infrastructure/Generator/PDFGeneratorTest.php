<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\Infrastructure\Generator;

use App\Module\Employee\Infrastructure\Generator\PDFGenerator;
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
        $path = __DIR__.self::TMP_DIR.'test.pdf';
        $this->PDFGenerator->generateSingleEmployeeReportPDF(10, 2.5, 01, $path);
        $this->assertFileExists($path);
        unlink($path);
    }

    public function testItGenerateReportForAllEmployees(): void
    {
        $path = __DIR__.self::TMP_DIR.'test.pdf';
        $this->PDFGenerator->generateAllEmployeesReportPDF(10, 2.5, 01, 10, $path);
        $this->assertFileExists($path);
        unlink($path);
    }
}
