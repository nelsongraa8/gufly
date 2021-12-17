<?php

namespace App\Controller;

use App\Repository\MoviesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Service\VerificationEMService;
use App\Service\FormatSalidaJSONMovieService;

class LastMovieController extends AbstractController
{
    /**
     * @Route("/lastmoviedata", name="lastmovie")
     */
    public function lastmovie(
        MoviesRepository $moviesRepository,
        // VerificationEMService $verificationemservice,
        //FormatSalidaJSONMovieService $formatSalidaJSONMovieService
    ): JsonResponse {
        /**
         * Traigo el repository en el que voy a trabajar como un parametro del metodo
         */
        $lastMovies = $moviesRepository->findLastMovies();

        /**
         * Verificar si se devolvio algun elemento
         */
        $verificationemservice = new VerificationEMService;
        if (!$lastMovies) {
            return $verificationemservice->VerificationEM($lastMovies);
        }

        $formatSalidaJSONMovieService = new FormatSalidaJSONMovieService;
        /** Retornar el response hecho de JSON */
        $response = new JsonResponse;
        return $response->setData(
            $formatSalidaJSONMovieService->FormatSalidaMovieArrayJSON($lastMovies)
        );
    }
}
