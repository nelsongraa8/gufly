<?php

namespace App\Service;

use App\Service\HttpAPIConnectService;

class FormatSalidaJSONMovieService
{
    /** Formateo de la salida de un array en JSON, en llamado desde cada metodo de este controlador */
    public function FormatSalidaMovieArrayJSON($movies_data)
    {
        /** movies hay que transformarlo en un array para despues mostrarlo en un JSON */
        $httpconnectapi = new HttpAPIConnectService;
        $moviesAsArray = [];
        foreach ($movies_data as $movie) {
            $moviesAsArray[] = [
                'id' => $movie->getId(),
                'tmdbid' => $movie->getTmdbid(),
                'nombre' => $movie->getNombre(),
                'anno' => $movie->getAnno(),
                'url' => $movie->getUrl(),
                'url_subtitulo' => $movie->getUrlSubtitulo(),
                'data_tmdb' => $httpconnectapi->HTTPConnectApiTMDBMovieData($movie),
            ];
        }

        return $moviesAsArray;
    }
}