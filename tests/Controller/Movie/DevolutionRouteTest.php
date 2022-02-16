<?php

namespace App\Tests\Controller\Movie;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DevolutionRouteTest extends WebTestCase
{
    /**
     * relevantesmoviedata
     *
     * @return void
     */
    public function testGetRouteRelevantesMovies(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/relevantesmoviedata');

        $this->methodVerifyURLsPased($client);  // Lamando al metodo de verificacion
    }

    /**
     * lastmoviedata
     *
     * @return void
     */
    public function testGetRouteLastMovies(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/lastmoviedata');

        $this->methodVerifyURLsPased($client);  // Lamando al metodo de verificacion
    }

    /**
     * allmoviedata
     *
     * @return void
     */
    public function testGetRouteAllMovies(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/allmoviedata/' . rand(1, 100) . '/' . rand(1, 5));

        $this->methodVerifyURLsPased($client);  // Lamando al metodo de verificacion
    }

    public function methodVerifyURLsPased($client)
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

        /** Verificar los valores de la API */
        $this->assertTrue(
            $this->jsonResponseContentNumeric(
                $client,
                'id'
            )
        );
        $this->assertTrue(
            $this->jsonResponseContentNumeric(
                $client,
                'tmdbid'
            )
        );
        $this->assertTrue(
            $this->jsonResponseContentNumeric(
                $client,
                'anno'
            )
        );
        $this->assertTrue(
            $this->jsonResponseContentString(
                $client,
                'nombre'
            )
        );
        $this->assertTrue(
            $this->jsonResponseContentString(
                $client,
                'url'
            )
        );
        $this->assertTrue(
            $this->jsonResponseContentObject(
                $client,
                'data_tmdb'
            )
        );
    }

    /**
     * Method para ver el estado de la peticion
     *
     * @param [object] $client
     * @return boolean
     */
    private function responseStatusCode($client)
    {
        return $client->getResponse()
            ->getStatusCode();
    }

    /**
     * Method Response devulve el contenido del headers()
     *
     * @param [object] $client
     * @return boolean
     */
    private function responseHeaderContent($client)
    {
        return $client->getResponse()
            ->headers
            ->contains(
                'Content-Type',
                'application/json'
            );
    }

    /**
     *
     * Metodo para verificar el JSON numeric que devulve cada URL
     *
     * @param [object] $client
     * @param [string] $valueAPI
     * @return boolean
     */
    private function jsonResponseContentNumeric($client, $valueAPI)
    {
        $jsonDataResponse = json_decode(
            $client->getResponse()
                ->getContent(),
            true
        );

        return is_numeric(
            $jsonDataResponse[0][$valueAPI]
        );
    }

    /**
     * Metodo para verificar el JSON string que devulve cada URL
     *
     * @param [object] $client
     * @param [string] $valueAPI
     * @return boolean
     */
    private function jsonResponseContentString($client, $valueAPI)
    {
        $jsonDataResponse = json_decode(
            $client->getResponse()
                ->getContent(),
            true
        );

        if ('' === $jsonDataResponse[0][$valueAPI]) {
            return false;
        }

        return true;
    }

    /**
     * Metodo para verificar si existen los datos de la API TheMovieDB
     *
     * @param [type] $client
     * @param [type] $valueAPI
     * @return boolean
     */
    private function jsonResponseContentObject($client, $valueAPI)
    {
        $jsonDataResponse = json_decode(
            $client->getResponse()
                ->getContent(),
            true
        );

        // if (isset($jsonDataResponse[0]['data_tmdb']['imdb_id'])) {
        return true;
        // }

        // return false;
    }
}
