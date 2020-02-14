<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\UI\HTTP\REST;

use Symfony\Component\HttpFoundation\Response;

final class EmployeeControllerTest extends UITestCase
{
    public function testItCreateEmployee(): void
    {
        $this->client->request('put', $this->router->generate('create_empployee'), [
                'first_name' => 'test',
                'last_name' => 'test',
                'address' => 'test',
                'remuneration_calculation_way' => 'hourly',
                'salary' => 200.0,
        ]);
        $response = $this->client->getResponse();
        $this->assertSame(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }
}
