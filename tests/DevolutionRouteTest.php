<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DevolutionRouteTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/lastmoviedata');

        /** Verificar esta URL */
        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );

        // Asegurar que el header "Content-Type" es "application/json"
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $data = json_decode(
            $client->getResponse()->getContent(),
            true
        );
        $this->assertTrue(
            is_numeric($data[0]['id'])
        );

    }
}
