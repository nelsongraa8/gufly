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
    public function allmovie( Request $request, MoviesRepository $moviesrepository )
    {

        /** Traigo el repository en el que voy a trabajar como un parametro del metodo */
        $movies = $moviesrepository->findAll();

        /** Verificar si se devolvio algun elemento */
        if( !$movies ) { return $this->verification_em( $movies ); }

        /** Retornar el response hecho de JSON */
        return $this->array_em_json( $movies );

    }


    /**
     * @Route("/moviedata/{id}", name="movie")
     */
    public function movie( int $id ): JsonResponse
    {

        /** Traigo el repository en el que voy a trabajar como un parametro del metodo */
        //$movies = $this->getDoctrine()->getRepository(Movies::class)->findBy(['id'=>$id]);
        $movies = $this->getDoctrine()->getRepository(Movies::class)->find($id);

        /** Verificar si se devolvio algun elemento */
        if( !$movies ) { return $this->verification_em( $movies ); }

        //$movie_data_json = $this->array_em_json( $movies );

        $movie_data_json_api = $this->HTTPConnectApiTMDB( $movies );

        /** Retornar el response hecho de JSON */
        return $movie_data_json_api;

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
        return $this->array_em_json( $relevantes );

    }

    /** Permite que el server haga 200 OK a un cliente diferente de este host */
    function __construct()
    {
        header('Access-Control-Allow-Origin:'.$_ENV['CLIENT_URL']);
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
    }

    /** Simple verificacion y mensaje de respuesta en formato JSON si no hay resultadso en la DB */
    public function verification_em( $var_verify )
    {
        return $this->json([
            'message' => 'Lo sentimos! No hay peliculas',
        ]);
    }

    /** Formateo de la salida de un array en JSON, en llamado desde cada metodo de este controlador */
    public function array_em_json( $movies )
    {
        /** movies hay que transformarlo en un array para despues mostrarlo en un JSON */
        $moviesAsArray = [];
        foreach ($movies as $movie) {
            $moviesAsArray[] = [
                'id' => $movie->getId(),
                'tmdbid' => $movie->getTmdbid(),
                'nombre' => $movie->getNombre(),
                'anno' => $movie->getAnno(),
                'productora' => $movie->getProductora(),
                'descripcion' => $movie->getDescripcion(),
                'poster' => $movie->getPoster(),
                'fanart' => $movie->getFanart(),
                'url' => $movie->getUrl(),
                'idioma_subtitulo' => $movie->getIdiomaSubtitulo(),
                'duracion' => $movie->getDuracion(),
                'director' => $movie->getDirector(),
                'genero' => $movie->getGenero(),
            ];
        }

        /** Devolver los datos como JSON y mandar en el el array que se creo con el foreach() */
        $response = new JsonResponse;

        return $response->setData([
            'success' => true,
            'data' => $moviesAsArray
        ]);
    }

    public function HTTPConnectApiTMDB( $movie )
    {
        /** Sacar los datos de la API de TheMovieDB */
        try {
            $res = json_decode(
                file_get_contents("http://api.themoviedb.org/3/movie/".$movie->getTmdbid()."?api_key=834059cb24bc11be719c241a12f537f4&language=es"),
                //file_get_contents("http://localhost/guflyjson/movie.json"),
                true
            );
        } catch (Exception $e) {
            $res = $e->getMessage();
        }

        try {
            $res_credits = json_decode(
                file_get_contents("http://api.themoviedb.org/3/movie/".$movie->getTmdbid()."/credits?api_key=834059cb24bc11be719c241a12f537f4&language=es"),
                //file_get_contents("http://localhost/guflyjson/credits.json"),
                true
            );
        } catch (Exception $e) {
            $res_credits = $e->getMessage();
        }

        $array_movie = [
            'id' => $movie->getId(),
            'tmdbid' => $movie->getTmdbid(),
            'nombre' => $movie->getNombre(),
            'url' => $movie->getUrl(),
            'url_subtitulo' => $movie->getIdiomaSubtitulo(),
        ];

        $response = new JsonResponse;
        return $response->setData([
            'data' => $array_movie,
            'data_api' => $res,
            'data_api_credits' => $res_credits
        ]);
    }

}
