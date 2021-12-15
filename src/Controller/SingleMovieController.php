<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Movies;
use App\Repository\MovieRepository;

class SingleMovieController extends AbstractController
{

    /** Permite que el server haga 200 OK a un cliente diferente de este host */
    function __construct()
    {
        header('Access-Control-Allow-Origin:' . $_ENV['CLIENT_URL']);
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
    }

    /**
     * @Route("/single/movie/{id_movie}", name="single_movie")
     */
    public function single_movie($id_movie): JsonResponse
    {
        /** Traigo el repository en el que voy a trabajar como un parametro del metodo */
        $movies = $this->getDoctrine()->getManager()->getRepository(Movies::class)->find($id_movie);

        /** Verificar si se devolvio algun elemento */
        if (!$movies) {
            return $this->json([
                'message' => 'El ID ' . $id_movie . ' no se encuentra DB'
            ]);
        }

        /** Retornar el response hecho de JSON */
        return $this->HTTPConnectApiTMDB($movies);
    }

    public function HTTPConnectApiTMDB($movie)
    {

        /** Diferencia entre desarrollo y produccion */
        if ($_ENV['APP_ENV'] == 'prod') {
            /** URL para entrorno de produccion */
            $url_json_decode = @file_get_contents("http://api.themoviedb.org/3/movie/" . $movie->getTmdbid() . "?api_key=834059cb24bc11be719c241a12f537f4&language=es");

            $urlcredits_json_decode = @file_get_contents("http://api.themoviedb.org/3/movie/" . $movie->getTmdbid() . "/credits?api_key=834059cb24bc11be719c241a12f537f4&language=es");
        } else {
            /** URL para entorno local de desarrollo con trolado */
            #$url_json_decode = file_get_contents("http://localhost/guflyjson/movie.json");
            $url_json_decode = @file_get_contents("http://api.themoviedb.org/3/movie/" . $movie->getTmdbid() . "?api_key=834059cb24bc11be719c241a12f537f4&language=es");

            #$urlcredits_json_decode = file_get_contents("http://localhost/guflyjson/credits.json");
            $urlcredits_json_decode = @file_get_contents("http://api.themoviedb.org/3/movie/" . $movie->getTmdbid() . "/credits?api_key=834059cb24bc11be719c241a12f537f4&language=es");
        }

        /** Sacar los datos de la API de TheMovieDB */
        /** Datos de la movie extraidos de la DB */
        try {
            $res = json_decode($url_json_decode, true);
        } catch (\Exception $e) {
            $res = $e->getMessage();
        }

        /** Creditos de la movie extraidos de la DB */
        try {
            $res_credits = json_decode($urlcredits_json_decode, true);
        } catch (\Exception $e) {
            $res_credits = $e->getMessage();
        }

        /** Array con los datos de la DB */
        $array_movie = [
            'id' => $movie->getId(),
            'tmdbid' => $movie->getTmdbid(),
            'nombre' => $movie->getNombre(),
            'url' => $movie->getUrl(),
            'url_subtitulo' => $movie->getIdiomaSubtitulo(),
        ];

        /** Salida de JSON pra el cliente */
        $response = new JsonResponse;
        return $response->setData([
            'data' => $array_movie,
            'data_api' => $res,
            'data_api_credits' => $res_credits
        ]);
    }
}
