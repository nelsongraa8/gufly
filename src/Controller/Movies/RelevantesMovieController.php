<?php

namespace App\Controller\Movies;

use App\Repository\MoviesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\Utils\JsonResponseContentObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RelevantesMovieController extends AbstractController
{
    /**
     * Repositoria para ejecutar la busqueda en la DB
     */
    public $moviesRepository;

    public function __construct(
        MoviesRepository $moviesRepositoryInjection,
    ) {
        $this->moviesRepository = $moviesRepositoryInjection;
    }

    /**
     * @Route("/relevantesmoviedata", name="relevantes")
     */
    public function relevantes(): JsonResponse
    {
        /** Traigo el repository en el que voy a trabajar como un parametro del metodo */
        $moviesFindDB = $this->moviesRepository
            ->findBy(
                ['relevante' => true]
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
