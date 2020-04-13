<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\UI\HTTP\REST;

use App\Module\Employee\Domain\Employee;
use App\Module\Employee\Tests\TestDouble\EmployeeMother;
use Symfony\Component\HttpFoundation\Response;

final class EmployeeControllerTest extends UITestCase
{
    public function testItCreateEmployee(): void
    {
        $this->client->request('put', $this->router->generate('create_empployee'), [
            'first_name'                   => 'test',
            'last_name'                    => 'test',
            'address'                      => 'test',
            'remuneration_calculation_way' => 'hourly',
            'salary'                       => 200.0,
        ]);
        $response = $this->client->getResponse();

        $this->assertSame(Response::HTTP_NO_CONTENT, $response->getStatusCode());
        $this->assertCount(1, $this->entityManager->getRepository(Employee::class)->findAll());
    }

    public function testItEmployeeWorkDay(): void
    {
        $employee = EmployeeMother::createEmployeeM();
        $this->entityManager->persist($employee);
        $this->entityManager->flush();
        /** @var Employee $employee */
        $employee = $this->entityManager->getRepository(Employee::class)->findOneBy([]);

        $this->client->request('put',
            $this->router->generate('empployee_worked_day', ['employeeId' => $employee->getId()->toString()]), [
                'hours_amount' => 10,
            ]);
        $response = $this->client->getResponse();
        $this->assertSame(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testItEmployeeWorkDayValidation(): void
    {
        $employee = EmployeeMother::createEmployeeM();
        $this->entityManager->persist($employee);
        $this->entityManager->flush();
        /** @var Employee $employee */
        $employee = $this->entityManager->getRepository(Employee::class)->findOneBy([]);

        $this->client->request('put',
            $this->router->generate('empployee_worked_day', ['employeeId' => $employee->getId()->toString()]), [
                'hours_amount' => 'test',
            ]);
        $response = $this->client->getResponse();
        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
