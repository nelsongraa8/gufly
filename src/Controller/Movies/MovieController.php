<?php

namespace App\Controller\Movies;

use App\Repository\MoviesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\Utils\JsonResponseContentObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MovieController extends AbstractController
{
    /**
     * Variable para la Injeccion de Dependencias
     *
     * @var [objects]
     */
    public $moviesFindDB;
    public $moviesRepository;
    public $jsonResponseContentObject;

    /**
     * Injectando las dependencias en esta clase
     *
     * @param MoviesRepository $moviesRepositoryInject
     * @param JsonResponseContentObject $jsonResponseContentObject
     */
    public function __construct(
        MoviesRepository $moviesRepository,
        JsonResponseContentObject $jsonResponseContentObject
    ) {
        $this->moviesRepository = $moviesRepository;
        $this->jsonResponseContentObject = $jsonResponseContentObject;
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
    public function allMovie($maxResultFindMovies, $idLimitMovie): JsonResponse
    {
        $this->moviesFindDB = $this->moviesRepository
            ->findAllMovies(
                $idLimitMovie,
                $maxResultFindMovies,
            );

        return $this->jsonDevolutionRequest();
    }

    /**
     * @Route("/lastmoviedata", name="lastmovie")
     *
     * Metodo para poder mostrar las peliculas mas relevantes
     */
    public function lastmovie()
    {
        $this->moviesFindDB = $this->moviesRepository
            ->findLastMovies();

        return $this->jsonDevolutionRequest();
    }

    /**
     * @Route("/relevantesmoviedata", name="relevantes")
     */
    public function relevantes(): JsonResponse
    {
        $this->moviesFindDB = $this->moviesRepository
            ->findBy(
                ['relevante' => true]
            );

        return $this->jsonDevolutionRequest();
    }

    /**
     * @Route("/searchmoviedata/{nameMovie}", name="search_movie")
     */
    public function searchMovie($nameMovie): JsonResponse
    {
        $this->moviesFindDB = $this->moviesRepository
            ->findAllNombreSearch(
                $nameMovie
            );

        return $this->jsonDevolutionRequest();
    }

    /**
     * Metodo para enviar el JSON al cliente
     *
     * @return JsonResponse
     */
    private function jsonDevolutionRequest()
    {
        return new JsonResponse(
            $this->jsonResponseContentObject->
                inputJsonResponseContentObject(
                    $this->moviesFindDB
                )
        );
    }
}
