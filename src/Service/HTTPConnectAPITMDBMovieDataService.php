<?php

namespace App\Service;

class HTTPConnectAPITMDBMovieDataService
{
    public function methodService($moviesid)
    {
        $moviescache = $moviesid->getThemoviedb();  // Variable para la cache
        $moviesidtmdb = $moviesid->getTmdbid();  // ID en el API de la movie

        /** Verificando si esta el ID del API de la movie */
        if ('' !== $moviesidtmdb) {
            /** Verificando si no esta almacenada en cache */
            if (!$moviescache) {
                /** Almacenando los datos buscados en la API */
                $resapirestmdb = json_decode(
                    @file_get_contents(
                        "http://api.themoviedb.org/3/movie/" . $moviesidtmdb . "?api_key=" . $_ENV['ID_API_TMDB']
                    ),
                    true
                );

                if (false !== $resapirestmdb) {
                    $persistMovieCacheService = new PersistMovieCacheService();
                    $persistMovieCacheService->functionPersistMoviesCache($moviesid, $resapirestmdb);
                }

                return $resapirestmdb;
            }
            if (false === is_null($moviescache)) {
                $resapirestmdb = [
                    'title' => $moviescache->getTitle(),
                    'release_date' => $moviescache->getReleaseDate(),
                    'backdrop_path' => $moviescache->getBackdropPath(),
                    'poster_path' => $moviescache->getPosterPath()
                ];

                return $resapirestmdb;
            }
        }
        if ('' === $moviesidtmdb) {
            return 'Data Less';
        }
    }
}
