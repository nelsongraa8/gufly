<?php

namespace App\Controller\Movies;

use App\Repository\MoviesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\Utils\JsonResponseContentObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AllMovieController extends AbstractController
{
    /**
     * Variable para la Injeccion de Dependencias
     *
     * @var [objects]
     */
    public $moviesRepository;

    /**
     * Injectando las dependencias en esta clase
     *
     * @param MoviesRepository $moviesRepositoryInject
     */
    public function __construct(
        MoviesRepository $moviesRepository
    ) {
        $this->moviesRepository = $moviesRepository;
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
     * @return object En formato Json
     */
    public function allMovie(
        $maxResultFindMovies,
        $idLimitMovie,
    ): JsonResponse {
        /** Traigo el repository en el que voy a trabajar como un parametro del metodo */
        $moviesFindDB = $this->moviesRepository
            ->findAllMovies(
                $idLimitMovie,
                $maxResultFindMovies,
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
