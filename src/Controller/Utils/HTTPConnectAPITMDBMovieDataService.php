<?php

namespace App\Controller\Utils;

use App\Controller\Utils\PersistMovieCacheService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HTTPConnectAPITMDBMovieDataService extends AbstractController
{
    /**
     * Objeto que representa la DB
     */
    private $moviesid;
    /**
     * Variable para la cache
     */
    private $moviescache;
    /**
     * ID en el API de la movie
     */
    private $moviesidtmdb;
    /**
     * Array donde estan los datos de la(s) movies que se quieren mostrar
    */
    private $resapirestmdb;

    public function methodService($moviesid): array
    {
        $this->moviesid     = $moviesid;
        $this->moviescache  = $moviesid->getThemoviedb();
        $this->moviesidtmdb = $moviesid->getTmdbid();

        /**
         * Verificando si esta el ID de TheMovieDB
         */
        if ('' !== $this->moviesidtmdb) {
            return $this->methodForMovieInDB();
        }
        if ('' === $this->moviesidtmdb) {
            return 'Data Less';
        }
    }

    /**
     * Verificando si no esta almacenada en cache
     */
    private function methodForMovieInDB(): array
    {
        if (true === is_null($this->moviescache)) {
            return $this->methodHTTPConnectAPI();
        }
        if (false === is_null($this->moviescache)) {
            return $this->methodDevolutionDataCacheMovieAPI();
        }
    }

    /**
     * Buscando los datos de la movie en la API
     */
    private function methodHTTPConnectAPI(): array
    {
        $this->resapirestmdb = json_decode(
            @file_get_contents(
                "http://api.themoviedb.org/3/movie/" . $this->moviesidtmdb . "?api_key=" . $_ENV['ID_API_TMDB']
            ),
            true
        );

        if (!$this->resapirestmdb) {
            $this->methodSaveDataCacheMovieAPI();
        }

        return $this->resapirestmdb;
    }

    /**
     * Buscando los datos de la pelicula almacenados en la DB en foma de Cache
     */
    private function methodDevolutionDataCacheMovieAPI(): array
    {
        $resapirestmdb = [
            'title'         => $this->moviescache->getTitle(),
            'release_date'  => $this->moviescache->getReleaseDate(),
            'backdrop_path' => $this->moviescache->getBackdropPath(),
            'poster_path'   => $this->moviescache->getPosterPath()
        ];

        return $resapirestmdb;
    }

    private function methodSaveDataCacheMovieAPI(): void
    {
        $persistMovieCacheService = new PersistMovieCacheService();
        $persistMovieCacheService->functionPersistMoviesCache(
            $this->moviesid,
            $this->resapirestmdb
        );
    }
}
