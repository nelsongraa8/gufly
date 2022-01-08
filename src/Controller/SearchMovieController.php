<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchMovieController extends AbstractController
{
    /**
     * @Route("/searchdata/{name_movie}", name="search_movie")
     */
    public function search_movie($name_movie, MoviesRepository $moviesRepository): JsonResponse
    {
        /** Traigo el repository en el que voy a trabajar como un parametro del metodo */
        $search_movie = $moviesRepository->findAllNombreSearch($name_movie);

        /** Verificar si se devolvio algun elemento */
        if (!$search_movie) {
            return $this->verification_em($search_movie);
        }

        /** Retornar el response hecho de JSON */
        $response = new JsonResponse;
        return $response->setData($this->array_em_json($search_movie));
    }
}
