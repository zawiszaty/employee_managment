<?php

declare(strict_types=1);


namespace App\Module\Employee\Tests\UI\HTTP\REST;


use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class UITestCase extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        $this->client = new Client([
            'base_uri' => '/'
        ]);
    }
}