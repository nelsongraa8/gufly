<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DevolutionRouteTest extends WebTestCase
{
    public function testGetRouteRelevantesMovies(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/relevantesdata');

        $this->methodVerifyURLsPased($client);  // Lamando al metodo de verificacion
    }

    public function testGetRouteLastMovies(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/lastmoviedata');

        $this->methodVerifyURLsPased($client);  // Lamando al metodo de verificacion
    }

    public function testGetRouteAllMovies(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/allmoviedata/'.rand(1, 100).'/'.rand(1, 5));

        $this->methodVerifyURLsPased($client);  // Lamando al metodo de verificacion
    }

    public function methodVerifyURLsPased( $client )
    {
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
    private function responseStatusCode( $client )
    {
        return $client->getResponse()
            ->getStatusCode();
    }

    /** Method Response devulve el contenido del headers() */
    private function responseHeaderContent( $client )
    {
        return $client->getResponse()
            ->headers
            ->contains(
                'Content-Type',
                'application/json'
            );
    }

    /** Metodo para verificar el JSON numeric que devulve cada URL */
    private function jsonResponseContentNumeric($client)
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
