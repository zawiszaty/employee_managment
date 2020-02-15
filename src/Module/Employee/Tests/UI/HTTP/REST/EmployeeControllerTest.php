<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\UI\HTTP\REST;

use App\Module\Employee\Infrastructure\ReadModel\View\EmployeeView;
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
        $this->assertCount(1, $this->entityManager->getRepository(EmployeeView::class)->findAll());
    }
}
