<?php

namespace App\Controller\Movies;

use App\Repository\MoviesRepository;
use App\Service\SalidaDataMovieService;
use App\Service\VerificationMovieDBService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RelevantesMovieController extends AbstractController
{
    public $moviesRepository;
    public $verificationemservice;
    public $formatSalidaJSONMovieService;

    public function __construct(
        /**
         * Repositoria para ejecutar la busqueda en la DB
         */
        MoviesRepository $moviesRepositoryInjection,
        /**
         * Servicio para verificar ala correcta devolucion de peliculas
         */
        VerificationMovieDBService $verificationemserviceInjection,
        /**
         * Servicio que me devulve un array de datos de a DB
         */
        SalidaDataMovieService $formatSalidaJSONMovieServiceInjection
    ) {
        $this->moviesRepository             = $moviesRepositoryInjection;
        $this->verificationemservice        = $verificationemserviceInjection;
        $this->formatSalidaJSONMovieService = $formatSalidaJSONMovieServiceInjection;
    }

    /**
     * @Route("/relevantesmoviedata", name="relevantes")
     */
    public function relevantes(): JsonResponse
    {
        /**
         * Traigo el repository en el que voy a trabajar como un parametro del metodo
         */
        $movies = $this->moviesRepository
            ->findBy(
                ['relevante' => true]
            );

        /**
         * Verificar si se devolvio algun elemento
         */
        if (!$movies) {
            return $this->verificationemservice
                ->VerificationEM();
        }

        /**
         * Retornar el response hecho de JSON
         */
        return new JsonResponse(
            $this->formatSalidaJSONMovieService
                ->formatSalidaMovieArrayJSON(
                    $movies
                )
        );
    }
}
