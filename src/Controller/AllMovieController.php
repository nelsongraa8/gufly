<?php

namespace App\Controller;

use App\Repository\MoviesRepository;
use App\Service\HeaderMethodService;
use App\Service\SalidaDataMovieService;
use App\Service\VerificationMovieDBService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AllMovieController extends AbstractController
{
    /**
     * Variables para la Injeccion de Dependencias
     *
     * @var [string]
     */
    public $moviesRepository;

    public $verificationMovieDBService;

    public $salidaDataMovieService;

    /**
     * Injectando las dependencias en esta clase
     *
     * @param MoviesRepository           $moviesRepositoryInject
     * @param VerificationMovieDBService $verificationMovieDBServiceInject
     * @param SalidaDataMovieService     $salidaDataMovieServiceInject
     */
    public function __construct(MoviesRepository $mRep, VerificationMovieDBService $vMDBS, SalidaDataMovieService $sDMS)
    {
        $this->moviesRepository = $mRep;
        $this->verificationMovieDBService = $vMDBS;
        $this->salidaDataMovieService = $sDMS;

        new HeaderMethodService(); // Anadir las cabeceras necesarias para la API
    }

    /**
     * @Route("/allmoviedata/{idLimitMovie}/{maxResultFindMovies}", name="allmovie")
     *
     * Mostrar todas las peliculas pasandole dos parametros para
     * saber el fin y el inicio del muestreo de los datos
     *
     * @param integer $maxResultFindMovies ID por el que empesar a buscar peliculas
     * @param integer $idLimitMovie        Numero de peliculas
     *
     * @return string En formato Json
     */
    public function allmovie($maxResultFindMovies, $idLimitMovie): JsonResponse
    {
        /**
         * Traigo el repository en el que voy a trabajar como un parametro del metodo
         */
        $movies = $this->moviesRepository
            ->findAllMovies(
                $idLimitMovie,
                $maxResultFindMovies,
            );

        if (!$movies) { // Verificar si se devolvio algun elemento
            return $this->verificationMovieDBService
                ->VerificationEM($movies);
        }

        /**
         * Devolver los datos como JSON y mandar en
         * el el array que se creo con el foreach()
         */
        $jsonResponse = new JsonResponse();
        return $jsonResponse
            ->setData(
                $this->salidaDataMovieService
                    ->FormatSalidaMovieArrayJSON($movies)
            );
    }
}
