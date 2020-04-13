<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\TestDouble;

use App\Module\Employee\Infrastructure\Generator\PDFGeneratorInterface;

final class SpyPDFGenerator implements PDFGeneratorInterface
{
    private int $counter = 0;

    public function generateSingleEmployeeReportPDF(int $hoursAmount, float $salary, int $month, string $filePath): void
    {
        $this->counter++;
    }

    public function getCounter(): int
    {
        return $this->counter;
    }

    public function generateAllEmployeesReportPDF(int $hoursAmount, float $salary, int $month, int $employeeAmount, string $filePath): void
    {
        $this->counter++;
    }
}