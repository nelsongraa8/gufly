<?php

namespace App\Controller\Movies;

use App\Repository\MoviesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\Utils\JsonResponseContentObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LastMovieController extends AbstractController
{
    /**
     * parametros para la inyeccion de dependencias
     */
    public $moviesRepository;

    /**
     * Inyectar las dependencias en el controlador, buenas practicas
     */
    public function __construct(
        MoviesRepository $moviesRepositoryInjection
    ) {
        $this->moviesRepository = $moviesRepositoryInjection;
    }

    /**
     * @Route("/lastmoviedata", name="lastmovie")
     *
     * Metodo para poder mostrar las peliculas mas relevantes
     */
    public function lastmovie()
    {
        /** Traigo el repository en el que voy a trabajar como un parametro del metodo */
        $moviesFindDB = $this->moviesRepository
            ->findLastMovies();

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
