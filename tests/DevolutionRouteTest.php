<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DevolutionRouteTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/relevantesdata');

        /** Verificar esta URL */
        $this->assertEquals(
            200,
            $this->responseStatusCode($client)
        );

        /** Asegurar que el header "Content-Type" es "application/json" */
        $this->assertTrue(
            $this->responseHeaderContent($client)
        );

        /** Verificar que la devolucion tenga almenos las ultimas peliculas */
        $this->assertTrue(
            $this->jsonResponseContentNumeric($client)
        );
    }

    /** Method para ver el estado de la peticion */
    public function responseStatusCode( $client )
    {
        return $client->getResponse()
            ->getStatusCode();
    }

    /** Method Response devulve el contenido del headers() */
    public function responseHeaderContent( $client )
    {
        return $client->getResponse()
            ->headers
            ->contains(
                'Content-Type',
                'application/json'
            );
    }

    /** Metodo para verificar el JSON numeric que devulve cada URL */
    public function jsonResponseContentNumeric($client)
    {
        $jsonDataResponse = json_decode(
            $client->getResponse()
                ->getContent(),
            true
        );

        return is_numeric(
            $jsonDataResponse[0]['id']
        );
    }
}
