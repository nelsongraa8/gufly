<?php

namespace App\Service;

use App\Service\PeristCacheDBMovieService;

class HttpAPIConnectService
{
    public function HTTPConnectApiTMDBMovieData($moviesid)
    {

        $moviescache = $moviesid->getThemoviedb();

        if ($moviesid->getTmdbid() != '') {

            if (!$moviescache) {
                $resapirestmdb = json_decode(
                    @file_get_contents("http://api.themoviedb.org/3/movie/" . $moviesid->getTmdbid() . "?api_key=834059cb24bc11be719c241a12f537f4"),
                    true
                );

                if ($resapirestmdb === false) {
                    $resapirestmdb = json_decode('Data Less');
                } else {
                    $cache_persis_movie = new PeristCacheDBMovieService;
                    $cache_persis_movie->functionPersistMoviesCache($moviesid, $resapirestmdb);
                }
            } else {
                $resapirestmdb = [
                    'title' => $moviescache->getTitle(),
                    'release_date' => $moviescache->getReleaseDate(),
                    'backdrop_path' => $moviescache->getBackdropPath(),
                    'poster_path' => $moviescache->getPosterPath()
                ];
            }

            return $resapirestmdb;
        } else {
            return 0;
        }
    }
}

