<?php

namespace App\Controller\Utils;

use App\Controller\Utils\SalidaDataMovieService;

class JsonResponseContentObject
{
    public function inputJsonResponseContentObject(
        $moviesFindDB
    ) {
        /** Verificar si se devolvio algun elemento */
        if (!$moviesFindDB) {
            return ['message' => 'Lo sentimos! No hay peliculas'];
        }

        $salidaDataMovieService = new SalidaDataMovieService;

        $jsonResponseMovie = $salidaDataMovieService
            ->formatSalidaMovieArrayJSON(
                $moviesFindDB
            );

        return $jsonResponseMovie;
    }
}
