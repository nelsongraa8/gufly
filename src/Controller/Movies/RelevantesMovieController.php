<?php

namespace App\Controller\Movies;

use App\Repository\MoviesRepository;
use App\Service\SalidaDataMovieService;
use App\Service\VerificationMovieDBService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\Utils\JsonResponseContentObject;
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
        $moviesFindDB = $this->moviesRepository
            ->findBy(
                ['relevante' => true]
            );

        /** Instanciando la clase para trabajar con los datos de la DB */
        $jsonResponseContentObject = new JsonResponseContentObject();

        /** Retornando el formato JSON */
        return new JsonResponse(
            $jsonResponseContentObject->inputJsonResponseContentObject(
                $moviesFindDB
            )
        );
    }
}
