<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VerificationMovieDBService
{
    /** Simple verificacion y mensaje de respuesta en formato JSON si no hay resultadso en la DB */
    public function VerificationEM()
    {
        return new JsonResponse(
            ['message' => 'Lo sentimos! No hay peliculas']
        );
    }
}