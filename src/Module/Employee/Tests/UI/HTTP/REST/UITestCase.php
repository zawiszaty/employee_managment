<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\UI\HTTP\REST;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Router;

class UITestCase extends WebTestCase
{
    protected Client $client;

    protected Router $router;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->router = self::$kernel->getContainer()->get('router');
        $this->client = new Client([
            'base_uri' => 'http://127.0.0.1/',
            'http_errors' => false,
        ]);
    }
}
