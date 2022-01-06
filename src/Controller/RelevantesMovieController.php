<?php

namespace App\Controller;

use App\Repository\MoviesRepository;
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
        MoviesRepository $moviesRepositoryInjection,  // Repositoria para ejecutar la busqueda en la DB
        VerificationMovieDBService $verificationemserviceInjection,  // Servicio para verificar ala correcta devolucion de peliculas
        SalidaDataMovieService $formatSalidaJSONMovieServiceInjection  // Servicio que me devulve un array de datos de a DB
    )
    {
        $this->moviesRepository = $moviesRepositoryInjection;  // Inyeccion
        $this->verificationemservice = $verificationemserviceInjection;  // Inyeccion
        $this->formatSalidaJSONMovieService = $formatSalidaJSONMovieServiceInjection;  // Inyeccion

        header('Access-Control-Allow-Origin:' . $_ENV['CLIENT_URL']);
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
    }

    /**
     * @Route("/relevantesdata", name="relevantes")
     */
    public function relevantes(): JsonResponse
    {
        /** Traigo el repository en el que voy a trabajar como un parametro del metodo */
        $movies = $this->moviesRepository
            ->findBy(['relevante' => true]);

        /** Verificar si se devolvio algun elemento */
        if (!$movies) {
            return $this->verificationemservice->VerificationEM();
        }

        /** Retornar el response hecho de JSON */
        return new JsonResponse(
            $this->formatSalidaJSONMovieService
                ->FormatSalidaMovieArrayJSON($movies)
        );
    }
}
