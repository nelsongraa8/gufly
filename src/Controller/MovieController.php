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

        return $this->json([
            'nombre' => $movies->getNombre(),
            'anno' => '2019',
            'productora' => 'Netflix',
            'descripcion' => 'El prestigioso guardaespaldas Michael Bryce recibe un nuevo cliente: un asesino a sueldo, Darius Kincaid, que debe testificar en un juicio en La Haya contra un cruel dictador.',
            'poster' => '',
            'fanart' => '',
            'url' => '',
            'idioma_subtitulo' => 'Español',
            'duracion' => '1h 58m',
            'director' => 'Patrick Hughes',
            'genero' => 'Accion'
        ]);
    }
}
