<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LastMovieController extends AbstractController
{
    /**
     * @Route("/lastmoviedata", name="lastmovie")
     */
    public function lastmovie(MoviesRepository $moviesRepository): JsonResponse
    {
        /** Traigo el repository en el que voy a trabajar como un parametro del metodo */
        $lastMovies = $moviesRepository->findLastMovies();

        /** Verificar si se devolvio algun elemento */
        if (!$lastMovies) {
            return $this->verification_em($lastMovies);
        }

        /** Retornar el response hecho de JSON */
        $response = new JsonResponse;
        return $response->setData($this->array_em_json($lastMovies));
    }
}
