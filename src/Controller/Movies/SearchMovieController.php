<?php

namespace App\Controller\Movies;

use App\Repository\MoviesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\Utils\JsonResponseContentObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchMovieController extends AbstractController
{
    public $moviesRepository;
    public function __construct(
        MoviesRepository $moviesRepository,
    ) {
        $this->moviesRepository = $moviesRepository;
    }

    /**
     * @Route("/searchmoviedata/{nameMovie}", name="search_movie")
     */
    public function searchMovie($nameMovie): JsonResponse
    {
        /** Traigo el repository en el que voy a trabajar como un parametro del metodo */
        $moviesFindDB = $this->moviesRepository
            ->findAllNombreSearch(
                $nameMovie
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
