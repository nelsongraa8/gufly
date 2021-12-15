<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MovieRelevantesController extends AbstractController
{
    /**
     * @Route("/relevantesdata", name="relevantes")
     */
    public function relevantes(): JsonResponse
    {

        /** Traigo el repository en el que voy a trabajar como un parametro del metodo */
        $em = $this->getDoctrine()->getManager();
        $relevantes = $em->getRepository(Movies::class)->findBy(['relevante' => true]);

        /** Verificar si se devolvio algun elemento */
        if (!$relevantes) {
            return $this->verification_em($relevantes);
        }

        /** Retornar el response hecho de JSON */
        $response = new JsonResponse;
        return $response->setData($this->array_em_json($relevantes));
    }
}
