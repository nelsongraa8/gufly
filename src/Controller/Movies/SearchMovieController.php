<?php

namespace App\Controller\Movies;

use App\Repository\MoviesRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Utils\SalidaDataMovieService;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\Utils\VerificationMovieDBService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchMovieController extends AbstractController
{
    public $moviesRepository;
    public $verificationMovieDBService;
    public $formatSalidaJSONMovieService;

    public function __construct(
        MoviesRepository           $moviesRepository,
        VerificationMovieDBService $verificationMovieDBService,
        SalidaDataMovieService $formatSalidaJSONMovieService
    ) {
        $this->moviesRepository             = $moviesRepository;
        $this->verificationMovieDBService   = $verificationMovieDBService;
        $this->formatSalidaJSONMovieService = $formatSalidaJSONMovieService;
    }

    /**
     * @Route("/searchmoviedata/{nameMovie}", name="search_movie")
     */
    public function searchMovie($nameMovie): JsonResponse
    {
        /** Traigo el repository en el que voy a trabajar como un parametro del metodo */
        $searchMovie = $this->moviesRepository
            ->findAllNombreSearch(
                $nameMovie
            );

        /** Verificar si se devolvio algun elemento */
        if (!$searchMovie) {
            return $this->verificationMovieDBService
                ->verificationEM(
                    $searchMovie
                );
        }

        /** Retornar el response hecho de JSON */
        return new JsonResponse(
            $this->formatSalidaJSONMovieService
                ->formatSalidaMovieArrayJSON(
                    $searchMovie
                )
        );
    }
}
