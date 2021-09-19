<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Movies;
use App\Repository\MoviesRepository;

class MovieController extends AbstractController
{
    /**
     * @Route("/moviedata/{id}", name="movie")
     */
    public function index( int $id ): Response
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
}
