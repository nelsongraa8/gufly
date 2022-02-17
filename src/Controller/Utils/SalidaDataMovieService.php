<?php

namespace App\Controller\Utils;

use App\Controller\Utils\HTTPConnectAPITMDBMovieDataService;

class SalidaDataMovieService
{
    private $moviesAsArray = [];
    /**
     * Formato de la salida de un array en JSON, ez llamado desde cada metodo de este controlador
     */
    public function formatSalidaMovieArrayJSON($movies_data)
    {
        $httpConnectApiTMDBMovieData = new HTTPConnectAPITMDBMovieDataService();

        /**
         * movies hay que transformarlo en un array para despues mostrarlo en un JSON
         */
        // $moviesAsArray = [];  // Array que retorna este metodo

        /**
         * Ciclo para crear el array relacional de la info de movies
         */
        foreach ($movies_data as $movie) {
            $this->moviesAsArray[] = [
                'id' => $movie->getId(),
                'tmdbid' => $movie->getTmdbid(),
                'nombre' => $movie->getNombre(),
                'anno' => $movie->getAnno(),
                'url' => $movie->getUrl(),
                'url_subtitulo' => $movie->getUrlSubtitulo(),
                'data_tmdb' => $httpConnectApiTMDBMovieData->methodService($movie)
            ];
        }

        return $this->moviesAsArray;
    }
}
