<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Movies;
use App\Repository\MoviesRepository;

class MovieController extends AbstractController
{

    /** Permite que el server haga 200 OK a un cliente diferente de este host */
    function __construct()
    {
        header('Access-Control-Allow-Origin:'.$_ENV['CLIENT_URL']);
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
    }

    /**
     * @Route("/", name="home")
     */
    public function start(): JsonResponse
    {
        return $this->json([
            'message' => 'Use directamente /allmoviedata',
        ]);
    }


    /**
     * @Route("/allmoviedata", name="allmovie")
     */
    public function allmovie( Request $request, MoviesRepository $moviesRepository ): JsonResponse
    {
        /** Traigo el repository en el que voy a trabajar como un parametro del metodo */
        $movies = $moviesRepository->findAllMovies();

        /** Verificar si se devolvio algun elemento */
        if( !$movies ) { return $this->verification_em( $movies ); }

        /** Devolver los datos como JSON y mandar en el el array que se creo con el foreach() */
        $response = new JsonResponse;
        return $response->setData( $this->array_em_json($movies) );
    }

    /**
     * @Route("/relevantesdata", name="relevantes")
     */
    public function relevantes(): JsonResponse
    {

        /** Traigo el repository en el que voy a trabajar como un parametro del metodo */
        $em = $this->getDoctrine()->getManager();
        $relevantes = $em->getRepository(Movies::class)->findBy(['relevante' => true ]);

        /** Verificar si se devolvio algun elemento */
        if( !$relevantes ) { return $this->verification_em( $relevantes ); }

        /** Retornar el response hecho de JSON */
        $response = new JsonResponse;
        return $response->setData( $this->array_em_json($relevantes) );

    }

    /**
     * @Route("/lastmoviedata", name="lastmovie")
     */
    public function lastmovie( MoviesRepository $moviesRepository ): JsonResponse
    {

        /** Traigo el repository en el que voy a trabajar como un parametro del metodo */
        $lastMovies = $moviesRepository->findLastMovies();

        /** Verificar si se devolvio algun elemento */
        if( !$lastMovies ) { return $this->verification_em( $lastMovies ); }

        /** Retornar el response hecho de JSON */
        $response = new JsonResponse;
        return $response->setData( $this->array_em_json($lastMovies) );

    }

    /**
     * @Route("/searchdata/{name_movie}", name="search_movie")
     */
    public function search_movie( $name_movie , MoviesRepository $moviesRepository ): JsonResponse
    {
        /** Traigo el repository en el que voy a trabajar como un parametro del metodo */
        $search_movie = $moviesRepository->findAllNombreSearch($name_movie);

        /** Verificar si se devolvio algun elemento */
        if( !$search_movie ) { return $this->verification_em( $search_movie ); }

        /** Retornar el response hecho de JSON */
        $response = new JsonResponse;
        return $response->setData( $this->array_em_json($search_movie) );
    }





    /**                                                   */
    /** Simple verificacion y mensaje de respuesta en formato JSON si no hay resultadso en la DB */
    public function verification_em( $var_verify )
    {
        return $this->json([
            'message' => 'Lo sentimos! No hay peliculas',
        ]);
    }

    /** Formateo de la salida de un array en JSON, en llamado desde cada metodo de este controlador */
    public function array_em_json( $movies_data )
    {
        /** movies hay que transformarlo en un array para despues mostrarlo en un JSON */
        $moviesAsArray = [];
        foreach ($movies_data as $movie) {
                $moviesAsArray[] = [
                    'id' => $movie->getId(),
                    'tmdbid' => $movie->getTmdbid(),
                    'nombre' => $movie->getNombre(),
                    'anno' => $movie->getAnno(),
                    'url' => $movie->getUrl(),
                    'idioma_subtitulo' => $movie->getIdiomaSubtitulo(),
                    'data_tmdb' => $this->HTTPConnectApiTMDBMovieData( $movie ),
                ];
        }

        return $moviesAsArray;
    }

    public function HTTPConnectApiTMDBMovieData( $moviesid ) {
        if( $moviesid->getTmdbid() != '' ) {
            $resapirestmdb = json_decode(
                file_get_contents("http://api.themoviedb.org/3/movie/".$moviesid->getTmdbid()."?api_key=834059cb24bc11be719c241a12f537f4"),
                true
            );

            return $resapirestmdb;
        } else {
            return 0;
        }
    }

}
