<?php

namespace App\Controller;

use App\Repository\MoviesRepository;
use App\Service\HeaderMethodService;
use App\Service\SalidaDataMovieService;
use App\Service\VerificationMovieDBService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RelevantesMovieController extends AbstractController
{
    //public $moviesRepository;
    public $moviesRepository;
    public $verificationemservice;
    public $formatSalidaJSONMovieService;

    /** Permite que el server haga 200 OK a un cliente diferente de este host */
    public function __construct(
        /** Repositoria para ejecutar la busqueda en la DB */
        MoviesRepository $moviesRepositoryInjection,
        /** Servicio para verificar ala correcta devolucion de peliculas */
        VerificationMovieDBService $verificationemserviceInjection,
        /** Servicio que me devulve un array de datos de a DB */
        SalidaDataMovieService $formatSalidaJSONMovieServiceInjection
    ) {
        $this->moviesRepository = $moviesRepositoryInjection;  // Inyeccion
        $this->verificationemservice = $verificationemserviceInjection;  // Inyeccion
        $this->formatSalidaJSONMovieService = $formatSalidaJSONMovieServiceInjection;  // Inyeccion

        new HeaderMethodService();
    }

    /**
     * @Route("/relevantesdata", name="relevantes")
     */
    public function relevantes(): JsonResponse
    {
        /** Traigo el repository en el que voy a trabajar como un parametro del metodo */
        $movies = $this->moviesRepository
            ->findBy(
                ['relevante' => true]
            );

        /** Verificar si se devolvio algun elemento */
        if (!$movies) {
            return $this->verificationemservice
                ->VerificationEM();
        }

        /** Retornar el response hecho de JSON */
        return new JsonResponse(
            $this->formatSalidaJSONMovieService
                ->FormatSalidaMovieArrayJSON(
                    $movies
                )
        );
    }
}
