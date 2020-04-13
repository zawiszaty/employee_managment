<?php

declare(strict_types=1);

namespace App\Module\Employee\Tests\TestDouble;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationFunctionalTestCase extends WebTestCase
{
    protected KernelBrowser $client;

    protected EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = self::$kernel->getContainer()->get('doctrine.orm.default_entity_manager');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
