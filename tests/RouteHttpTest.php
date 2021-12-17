<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;

class RouteHttpTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }

    // public function RoutehttpTest(): void
    // {
    //     $client_http = new HttpClient('127.0.0.1:8000');

    //     $this->assertTrue(200, $client_http->sendRequest());
    // }
}
