<?php

declare(strict_types=1);

namespace App\Module\Employee\Infrastructure\Generator;

use Mpdf\Mpdf;

class PDFGenerator implements PDFGeneratorInterface
{
    private Mpdf $mpdf;

    public function __construct(Mpdf $mpdf)
    {
        $this->mpdf = $mpdf;
    }

    public function generateSingleEmployeeReportPDF(int $hoursAmount, float $salary, int $month, string $filePath): void
    {
        $this->mpdf->SetDisplayMode('fullpage');
        $this->mpdf->SetHeader('{DATE j-m-Y}| Salary Report for |{PAGENO}');
        $this->mpdf->SetFooter('Szymon Ciompała EmployeeManagment');
        $html = "
        <html>
            <body>
                <div>HoursAmount: $hoursAmount</div>
                <div>Salary: $salary</div>
                <div>Month: $month</div>
            </body>
        </html>
        ";
        $this->mpdf->WriteHTML($html);
        $this->mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);
    }

    public function generateAllEmployeesReportPDF(int $hoursAmount, float $salary, int $month, int $employeeAmount, string $filePath): void
    {
        $this->mpdf->SetDisplayMode('fullpage');
        $this->mpdf->SetHeader('{DATE j-m-Y}| Salary Report for |{PAGENO}');
        $this->mpdf->SetFooter('Szymon Ciompała EmployeeManagment');
        $html = "
        <html>
            <body>
                <div>HoursAmount: $hoursAmount</div>
                <div>Salary: $salary</div>
                <div>Month: $month</div>
                <div>Employees Amount: $employeeAmount</div>
            </body>
        </html>
        ";
        $this->mpdf->WriteHTML($html);
        $this->mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);
    }
}
