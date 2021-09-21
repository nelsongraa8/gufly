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

        $movies = $moviesrepository->findAll();

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

        if( !$movies ) {
            return $this->json([
                'message' => 'No product found for id ',
            ]);
        }

        $response = new JsonResponse;
        $response->setData([
            'success' => true,
            'data' => $moviesAsArray
        ]);

        return $response;

    }
}
