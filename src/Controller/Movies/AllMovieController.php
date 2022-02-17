<?php

namespace App\Controller\Movies;

use App\Repository\MoviesRepository;
// use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Utils\SalidaDataMovieService;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\Utils\VerificationMovieDBService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AllMovieController extends AbstractController
{
    /**
     * Variables para la Injeccion de Dependencias
     *
     * @var [objects]
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
    public function __construct(
        MoviesRepository $mRep,
        VerificationMovieDBService $vMDBS,
        SalidaDataMovieService $sDMS,
    ) {
        $this->moviesRepository           = $mRep;
        $this->verificationMovieDBService = $vMDBS;
        $this->salidaDataMovieService     = $sDMS;
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
    public function allMovie(
        $maxResultFindMovies,
        $idLimitMovie,
    ): JsonResponse {
        /**
         * Traigo el repository en el que voy a trabajar como un parametro del metodo
         */
        $movies = $this->moviesRepository
            ->findAllMovies(
                $idLimitMovie,
                $maxResultFindMovies,
            );

        /**
         * Verificar si se devolvio algun elemento
         */
        if (!$movies) {
            return $this->verificationMovieDBService
                ->VerificationEM(
                    $movies
                );
        }

        $jsonresponse = new JsonResponse();
        $jsonresponse->setData(
            $this->salidaDataMovieService
                ->formatSalidaMovieArrayJSON(
                    $movies
                )
        );

        // $jsonresponse->headers->set('Content-Type', 'application/json');
        // $jsonresponse->headers->set('Access-Control-Allow-Origin', '*');

        return $jsonresponse;
        /**
         * Devolver los datos como JSON y mandar en
         * el el array que se creo con el foreach()
         */
        // return new JsonResponse(
        //     $this->salidaDataMovieService
        //         ->formatSalidaMovieArrayJSON(
        //             $movies
        //         )
        // );
    }
}
