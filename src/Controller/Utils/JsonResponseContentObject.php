<?php

namespace App\Controller\Utils;

use App\Service\Movie\OutputDataMovieService;

class JsonResponseContentObject
{
    public $salidaDataMovieService;

    public function __construct(OutputDataMovieService $salidaDataMovieService)
    {
        $this->salidaDataMovieService = $salidaDataMovieService;
    }

    public function inputJsonResponseContentObject($moviesFindDB): array
    {
        /** Verificar si se devolvio algun elemento */
        if (!$moviesFindDB) {
            return ['message' => 'Lo sentimos! No hay peliculas'];
        }

        $jsonResponseMovie = $this->salidaDataMovieService
            ->formatSalidaMovieArrayJSON(
                $moviesFindDB
            );

        return $jsonResponseMovie;
    }
}
