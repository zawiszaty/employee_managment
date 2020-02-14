<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\Infrastructure;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Router;

class InfrastructureTestCase extends WebTestCase
{
    protected Router $router;

    protected EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = self::$kernel->getContainer()->get('doctrine.orm.default_entity_manager');
        $this->router = self::$kernel->getContainer()->get('router');
    }
}
