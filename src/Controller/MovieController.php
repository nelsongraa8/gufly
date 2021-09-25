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
    public function start( Request $request, MoviesRepository $moviesrepository ): JsonResponse
    {

        /** Traigo el repository en el que voy a trabajar como un parametro del metodo */
        $movies = $moviesrepository->findAll();

        /** Verificar si se devolvio algun elemento */
        if( !$movies ) {
            return $this->json([
                'message' => 'Lo sentimos! No hay peliculas',
            ]);
        }

        /** movies hay que transformarlo en un array para despues mostrarlo en un JSON */
        $moviesAsArray = [];
        foreach ($movies as $movie) {
            $moviesAsArray[] = [
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
        $response->setData([
            'success' => true,
            'data' => $moviesAsArray
        ]);

        header('Access-Control-Allow-Origin: http://localhost:4200');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");

        /** Retornar el response hecho de JSON */
        return $response;

    }

    /**
     * @Route("/moviedata/{id}", name="movie")
     */
    public function movie( int $id ): JsonResponse
    {

        $movies = $this->getDoctrine()->getRepository(Movies::class)->find($id);

        if( !$movies ) {
            return $this->json([
                'message' => 'No product found for id '.$id,
            ]);
        }

        return $this->json([
            'nombre' => $movies->getNombre(),
            'anno' => $movies->getAnno(),
            'productora' => $movies->getProductora(),
            'descripcion' => $movies->getDescripcion(),
            'poster' => $movies->getPoster(),
            'fanart' => $movies->getFanart(),
            'url' => $movies->getUrl(),
            'idioma_subtitulo' => $movies->getIdiomaSubtitulo(),
            'duracion' => $movies->getDuracion(),
            'director' => $movies->getDirector(),
            'genero' => $movies->getGenero(),
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
        if( !$movies ) {
            return $this->json([
                'message' => 'Lo sentimos! No hay peliculas',
            ]);
        }

        /** movies hay que transformarlo en un array para despues mostrarlo en un JSON */
        $moviesAsArray = [];
        foreach ($movies as $movie) {
            $moviesAsArray[] = [
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
        $response->setData([
            'success' => true,
            'data' => $moviesAsArray
        ]);

        header('Access-Control-Allow-Origin: http://localhost:4200');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");

        /** Retornar el response hecho de JSON */
        return $response;

    }
}
