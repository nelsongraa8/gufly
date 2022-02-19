<?php

namespace App\Service\Movie;

use App\Service\Movie\HTTPConnectAPITMDBMovieDataService;

class OutputDataMovieService
{
    private $moviesAsArray = array();
    private $httpConnectApiTmbdMovie;

    public function __construct(HTTPConnectAPITMDBMovieDataService $httpConnectApiTmbdMovie)
    {
        $this->httpConnectApiTmbdMovie = $httpConnectApiTmbdMovie;
    }

    public function formatSalidaMovieArrayJSON($moviesDataDB): array
    {
        // $httpConnectApiTMDBMovieData = new HTTPConnectAPITMDBMovieDataService();

        foreach ($moviesDataDB as $movie) {
            $this->moviesAsArray[] = array(
                'id' => $movie->getId(),

                'tmdbid' => $movie->getTmdbid(),

                'nombre' => $movie->getNombre(),

                'anno' => $movie->getAnno(),

                'url' => $movie->getUrl(),

                'url_subtitulo' => $movie->getUrlSubtitulo(),

                'data_tmdb' => $this->httpConnectApiTmbdMovie
                    ->methodService($movie)
            );
        }

        return $this->moviesAsArray;
    }
}
