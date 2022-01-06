<?php

namespace App\Controller;

use App\Repository\MoviesRepository;
use App\Service\SalidaDataMovieService;
use App\Service\VerificationMovieDBService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RelevantesMovieController extends AbstractController
{
    public $moviesRepository;

    /** Permite que el server haga 200 OK a un cliente diferente de este host */
    function __construct(MoviesRepository $repos)
    {
        $this->moviesRepository = $repos;

        header('Access-Control-Allow-Origin:' . $_ENV['CLIENT_URL']);
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
    }

    /**
     * @Route("/relevantesdata", name="relevantes")
     */
    public function relevantes(): JsonResponse
    {
        /** Traigo el repository en el que voy a trabajar como un parametro del metodo */
        $movies = $this->moviesRepository
            ->findBy(['relevante' => true]);

        /** Verificar si se devolvio algun elemento */
        if (!$movies) {
            $verificationMovieDBService = new VerificationMovieDBService;
            return $verificationMovieDBService->VerificationEM($movies);
        }

        /** Devolver los datos como JSON y mandar en el el array que se creo con el foreach() */
        $formatsalida = new SalidaDataMovieService;
        $responsejson = new JsonResponse;
        return $responsejson->setData(
            $formatsalida->FormatSalidaMovieArrayJSON($movies)
        );
    }
}
