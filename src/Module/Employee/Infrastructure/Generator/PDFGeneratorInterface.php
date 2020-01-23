<?php

declare(strict_types=1);

namespace App\Module\Employee\Infrastructure\Generator;

interface PDFGeneratorInterface
{
    public function generateSingleEmployeeReportPDF(int $hoursAmount, float $salary, int $month): string;
}
