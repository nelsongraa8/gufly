<?php

namespace App\Service;

use App\Service\HTTPConnectAPITMDBMovieDataService;

class SalidaDataMovieService
{
    /**
     * Formateo de la salida de un array en JSON, en llamado desde cada metodo de este controlador
     */
    public function formatSalidaMovieArrayJSON($movies_data)
    {
        $httpConnectApiTMDBMovieData = new HTTPConnectApiTMDBMovieDataService();
        /**
         * movies hay que transformarlo en un array para despues mostrarlo en un JSON
         */
        $moviesAsArray = [];  // Array que retorna este metodo
        foreach ($movies_data as $movie) {  // Ciclo para crear el array relacional de la info de movies
            $moviesAsArray[] = [
                'id' => $movie->getId(),
                'tmdbid' => $movie->getTmdbid(),
                'nombre' => $movie->getNombre(),
                'anno' => $movie->getAnno(),
                'url' => $movie->getUrl(),
                'url_subtitulo' => $movie->getUrlSubtitulo(),
                'data_tmdb' => $httpConnectApiTMDBMovieData  //Llamando al metodo para buscar en la API
                    ->methodService($movie),
            ];
        }

        return $moviesAsArray;
    }
}
