<?php

declare(strict_types=1);

namespace App\Module\Employee\UI\HTTP\REST;

use App\Module\Employee\Application\Command\GenerateReport\Salary\GenerateSalaryReport\GenerateSalaryReportForSingleEmployeeCommand;
use App\Module\Employee\Application\EmployeeAPIInterface;
use App\Module\Employee\UI\HTTP\REST\Request\GenerateSalaryReportSingleEmployeeRequest;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GenerateSalaryReportController extends AbstractController
{
    private EmployeeAPIInterface $employeeAPI;

    public function __construct(EmployeeAPIInterface $employeeAPI)
    {
        $this->employeeAPI = $employeeAPI;
    }

    /**
     * @Route("/api/v1/salary_report/{employeeId}", name="generate_salary_report_single_employee", methods={"POST"})
     */
    public function generateForSingleEmployee(string $employeeId, GenerateSalaryReportSingleEmployeeRequest $request): Response
    {
        $this->employeeAPI->handle(new GenerateSalaryReportForSingleEmployeeCommand(
            $employeeId,
            DateTimeImmutable::createFromFormat('m', (string) $request->getMonth())
        ));

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}