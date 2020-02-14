<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\UI\HTTP\REST;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Router;

class UITestCase extends WebTestCase
{
    protected KernelBrowser $client;

    protected Router $router;

    protected EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->client = self::createClient([
            'environment' => 'test',
            'http_errors' => false,
        ]);
        $this->client->disableReboot();
        self::bootKernel();
        $this->entityManager = self::$kernel->getContainer()->get('doctrine.orm.default_entity_manager');
        $this->router = self::$kernel->getContainer()->get('router');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
