<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\UI\HTTP\REST;

use Symfony\Component\HttpFoundation\Response;

final class EmployeeControllerTest extends UITestCase
{
    public function testItCreateEmployee(): void
    {
        $response = $this->client->put($this->router->generate('create_empployee'), [
            'json' => [
                'first_name'                   => 'test',
                'last_name'                    => 'test',
                'address'                      => 'test',
                'remuneration_calculation_way' => 'test',
                'salary'                       => 200.0,
            ]
        ]);
        $this->assertSame(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }
}
