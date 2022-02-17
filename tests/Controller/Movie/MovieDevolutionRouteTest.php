<?php

namespace App\Tests\Controller\Movie;

use App\Tests\Utils\VerifyURLsPased;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieDevolutionRouteTest extends WebTestCase
{
    /**
     * relevantesmoviedata
     *
     * @return void
     */
    public function testGetRouteRelevantesMovies(): void
    {
        $this->inputTestGeneralMethod('/relevantesmoviedata');
    }

    /**
     * lastmoviedata
     *
     * @return void
     */
    public function testGetRouteLastMovies(): void
    {
        $this->inputTestGeneralMethod('/lastmoviedata');
    }

    /**
     * allmoviedata
     *
     * @return void
     */
    public function testGetRouteAllMovies(): void
    {
        $this->inputTestGeneralMethod('/allmoviedata/' . rand(1, 100) . '/' . rand(1, 5));
    }

    /**
     * searchmoviedata
     *
     * @return void
     */
    public function testGetRouteSearchMovies(): void
    {
        $this->inputTestGeneralMethod('/searchmoviedata/Marksman');
    }


    private function inputTestGeneralMethod($url)
    {
        $client = static::createClient();
        $crawler = $client->request('GET', $url);

        $verifyURLsPased = new VerifyURLsPased();
        $verifyURLsPased->methodVerifyURLsPased($client);
    }
}
