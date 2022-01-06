<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\HttpFoundation\Request;

use App\Entity\Movies;
use App\Repository\MoviesRepository;

class AddMovieController extends AbstractController
{

    private $url_json = 'https://guflyscanner.vercel.app/';

    /**
     * @Route("/addautomovieadmin/{count}", name="add_movie")
     */
    public function addmovie( $count , MoviesRepository $moviesrepository ): JsonResponse
    {

        /** Almaceno todo el json en una variable */
        $res_json_all_movie = json_decode(
            file_get_contents( $this->url_json ),
            true
        );

        $index_counter_add = 0;
        $index_counter_no_add = 0;
        $array_name_insert = [];
        foreach ($res_json_all_movie as $key => $value)
        {
            /** Decodificar la varibale por si hay espacios enblanco y caracteres especiales %20 */
            $name_movie_format = urlencode( $value['name_video'] );
            $res_movie_tmbd = json_decode(
                file_get_contents( "http://api.themoviedb.org/3/search/movie?api_key=".$_ENV['ID_API_TMDB']."&language=es&year=".$value['anno_video']."&query=".$name_movie_format ),
                true
            );

            /**  Verificando si existe o no el ID en themoviedb */
            if( isset($res_movie_tmbd['results'][0]['id']) )
            {
                $idtmdb = $res_movie_tmbd['results'][0]['id'];
            }
            else
            {
                $idtmdb = '';
            }

            /**  Verifico si el ID correctamente existe y no esta vacio */
            if( $idtmdb != '' ) {
                $nombre_movie = $value['name_video'];
                $anno_movie = '2021';
                $url_movie = $value['url_video'];

                /**  Buscar en la DB */
                $movie_in_db = $moviesrepository->findBy(['nombre' => $nombre_movie ]);

                /**  Verificar si existe la pelicula, se verifica por el nombre */
                if( !$movie_in_db ) {
                    /**  Annadir la entrada a la DB */
                    $movies = new Movies();
                    $movies->setTmdbid( $idtmdb );
                    $movies->setNombre( $nombre_movie );
                    $movies->setAnno( $anno_movie );
                    $movies->setUrl( $url_movie );

                    /**  Persistir los datos en la DB */
                    $emtity = $this->getDoctrine()->getManager();
                    $emtity->persist( $movies );
                    $emtity->flush();

                    /**  Annadiendo 1 al contador de peliculas annadidas a la DB */
                    $index_counter_add++;

                    /**  Guardando en un array las movies annadidas correctamente a la DB */
                    $array_name_insert[ $index_counter_add ] = $nombre_movie;
                }
            } else {
                /**  Annadir uno al contador de peliculas no annadidas */
                $index_counter_no_add++;
                /**  Annadir a un array el nombre de la pelicula que no se pudo annadir a la DB por falta de ID de themoviedb */
                $array_name_no_insert[ $index_counter_no_add ] = $value['name_video'];
            }

            /**  Verificando si debo acabar el ciclo por introducir el numero de movies requeridas */
            if( $index_counter_add > $count ) {
                /**  Terminando el bucle porque ya se annadieron el numero de movies introducidas en la url [$count] */
                break;
            }
        }

        /**  Devolver un JSON con datos de log */
        return $this->json([
            'movie_insert' => $array_name_insert,  // Movies annadidos carrectamente a la DB
            'movie_no_insert' => $array_name_no_insert  // Movies que no se pudieron annadir a la DB
        ]);
    }
}
