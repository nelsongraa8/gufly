<?php

namespace App\Controller;

use App\Repository\MoviesRepository;
use App\Service\HeaderMethodService;
use App\Service\SalidaDataMovieService;
use App\Service\VerificationMovieDBService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LastMovieController extends AbstractController
{
    /** parametros para la inyeccion de dependencias */
    public $moviesRepository;
    public $verificationemservice;
    public $formatSalidaJSONMovieService;
    public $headerMethodService;

    /** Inyectar las dependencias en el controlador, buenas practicas */
    public function __construct(
        MoviesRepository $moviesRepositoryInjection,  // Repositoria para ejecutar la busqueda en la DB
        VerificationMovieDBService $verificationemserviceInjection,  // Servicio para verificar ala correcta devolucion de peliculas
        SalidaDataMovieService $formatSalidaJSONMovieServiceInjection  // Servicio que me devulve un array de datos de a DB
    )
    {
        $this->moviesRepository = $moviesRepositoryInjection;  // Inyeccion
        $this->verificationemservice = $verificationemserviceInjection;  // Inyeccion
        $this->formatSalidaJSONMovieService = $formatSalidaJSONMovieServiceInjection;  // Inyeccion

        new HeaderMethodService();
    }

    /**
     * @Route("/lastmoviedata", name="lastmovie")
     *
     * Metodo para poder mostrar las peliculas mas relevantes
     */
    public function lastmovie() {

        /** Traigo el repository en el que voy a trabajar como un parametro del metodo */
        $lastMovies = $this->moviesRepository->findLastMovies();

        /** Verificar si se devolvio algun elemento */
        if (!$lastMovies) {
            return $this->verificationemservice->VerificationEM();
        }

        /** Retornar el response hecho de JSON */
        return new JsonResponse(
            $this->formatSalidaJSONMovieService
                ->FormatSalidaMovieArrayJSON($lastMovies)
        );
    }
}
