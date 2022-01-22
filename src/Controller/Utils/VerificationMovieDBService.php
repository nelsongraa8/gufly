<?php

namespace App\Controller\Utils;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VerificationMovieDBService extends AbstractController
{
    /** Simple verificacion y mensaje de respuesta en formato JSON si no hay resultadso en la DB */
    public function verificationEM()
    {
        return new JsonResponse(
            ['message' => 'Lo sentimos! No hay peliculas']
        );
    }
}
