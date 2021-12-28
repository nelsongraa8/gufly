<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\MoviesRepository;

use App\Service\SalidaDataMovieService;

class AllMovieController extends AbstractController
{
    public $moviesRepository;

    /** Permite que el server haga 200 OK a un cliente diferente de este host */
    function __construct( MoviesRepository $repos )
    {
        $this->moviesRepository = $repos;

        header('Access-Control-Allow-Origin:' . $_ENV['CLIENT_URL']);
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
    }

    /**
     * @Route("/allmoviedata/{id_limit_movie}/{max_result_find}", name="allmovie")
     */
    public function allmovie(
        $max_result_find,
        $id_limit_movie,
    ): JsonResponse
    {
        /** Traigo el repository en el que voy a trabajar como un parametro del metodo */
        $movies = $this->moviesRepository->findAllMovies($id_limit_movie, $max_result_find);

        /** Verificar si se devolvio algun elemento */
        // if (!$movies) {
        //     $verificacion_movie = new VerificationEMService;
        //     return $verificacion_movie->VerificationEM($movies);
        // }

        /** Devolver los datos como JSON y mandar en el el array que se creo con el foreach() */
        $formatsalida = new SalidaDataMovieService;
        $response = new JsonResponse;
        return $response->setData($formatsalida->FormatSalidaMovieArrayJSON( $movies ));
    }
}
