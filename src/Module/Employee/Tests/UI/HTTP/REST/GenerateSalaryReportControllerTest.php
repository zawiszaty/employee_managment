<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\UI\HTTP\REST;

use App\Infrastructure\Domain\Clock;
use App\Module\Employee\Domain\Employee;
use App\Module\Employee\Domain\Entity\SalaryReport;
use App\Module\Employee\Domain\Entity\WorkedDay;
use App\Module\Employee\Tests\TestDouble\EmployeeMother;
use Symfony\Component\HttpFoundation\Response;

final class GenerateSalaryReportControllerTest extends UITestCase
{
    public function testITGenerateReport(): void
    {
        $employee = EmployeeMother::createEmployeeM();
        $clock = Clock::system();
        $employee->workedDay(WorkedDay::create(10, $clock, $employee->getId()));
        $this->entityManager->persist($employee);
        $this->entityManager->flush();
        /** @var Employee $employee */
        $employee = $this->entityManager->getRepository(Employee::class)->findOneBy([]);

        $this->client->request(
            'post',
            $this->router->generate('generate_salary_report_single_employee', [
                'employeeId' => $employee->getId()->toString(),
            ]),
            [
                'month' => $clock->currentDateTime()->format('m'),
            ]
        );

        $response = $this->client->getResponse();
        $this->assertSame(Response::HTTP_NO_CONTENT, $response->getStatusCode());
        $salaryReport = $this->entityManager->getRepository(SalaryReport::class)
            ->findOneBy(['employeeId' => $employee->getId()->toString()]);
        $this->assertNotNull($salaryReport);
        /* @var SalaryReport $salaryReport */
        unlink($salaryReport->getPath()->getValue());
    }
}
