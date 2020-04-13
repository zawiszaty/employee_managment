<?php

declare(strict_types=1);

namespace App\Module\Employee\UI\HTTP\REST;

use App\Module\Employee\Application\Command\CreateEmployee\CreateEmployeeCommand;
use App\Module\Employee\Application\Command\EmployeeWorkedDay\EmployeeWorkedDayCommand;
use App\Module\Employee\Application\EmployeeAPIInterface;
use App\Module\Employee\UI\HTTP\REST\Request\CreateEmployeeRequest;
use App\Module\Employee\UI\HTTP\REST\Request\EmployeeWorkedDayRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class EmployeeController extends AbstractController
{
    private EmployeeAPIInterface $employeeAPI;

    public function __construct(EmployeeAPIInterface $employeeAPI)
    {
        $this->employeeAPI = $employeeAPI;
    }

    /**
     * @Route("/api/v1/employees", name="get_employees", methods={"GET"})
     */
    public function getEmployees(): Response
    {
        return new Response('test');
    }

    /**
     * @Route("/api/v1/employee/{id}", name="get_employee", methods={"GET"})
     */
    public function getEmployee(string $id): Response
    {
        dump($this->employeeAPI);

        return new Response("employee: $id");
    }

    /**
     * @Route("/api/v1/employee", name="create_empployee", methods={"PUT"})
     */
    public function createEmployee(CreateEmployeeRequest $request): Response
    {
        $this->employeeAPI->handle(new CreateEmployeeCommand(
            $request->getFirstName(),
            $request->getLastName(),
            $request->getAddress(),
            $request->getRemunerationCalculationWay(),
            $request->getSalary(),
        ));

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/api/v1/employee/{employeeId}/work/day", name="empployee_worked_day", methods={"PUT"})
     */
    public function employeeWorkedDay(EmployeeWorkedDayRequest $request, string $employeeId): Response
    {
        $this->employeeAPI->handle(new EmployeeWorkedDayCommand(
            $employeeId,
            (int) $request->getHoursAmount()
        ));

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
