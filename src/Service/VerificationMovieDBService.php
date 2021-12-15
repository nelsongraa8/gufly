<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VerificationEMService extends AbstractController
{
    /** Simple verificacion y mensaje de respuesta en formato JSON si no hay resultadso en la DB */
    public function VerificationEM($var_verify)
    {
        return $this->json([
            'message' => 'Lo sentimos! No hay peliculas',
        ]);
    }
}