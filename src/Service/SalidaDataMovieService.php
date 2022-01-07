<?php

namespace App\Service;

// use App\Entity\Themoviedb;
// use App\Repository\ThemoviedbRepository;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SalidaDataMovieService
{
    // private $abstractControllerRepository;
    // public $abstractController;

    // public function __construct(
    //     Themoviedb $ThemoviedbInject,
    //     ThemoviedbRepository $themoviedbRepositoryInject
    // )
    // {
    //     $this->themoviedb = $ThemoviedbInject;
    //     $this->themoviedbRepository = $themoviedbRepositoryInject;
    // }

    /**
     * Formateo de la salida de un array en JSON, en llamado desde cada metodo de este controlador
     */
    public function FormatSalidaMovieArrayJSON($movies_data)
    {
        /**
         * movies hay que transformarlo en un array para despues mostrarlo en un JSON
         */
        $moviesAsArray = [];  // Array que retorna este metodo
        foreach ($movies_data as $movie) {  // Ciclo para crear el array relacional de la info de movies
            $moviesAsArray[] = [
                'id' => $movie->getId(),
                'tmdbid' => $movie->getTmdbid(),
                'nombre' => $movie->getNombre(),
                'anno' => $movie->getAnno(),
                'url' => $movie->getUrl(),
                'url_subtitulo' => $movie->getUrlSubtitulo(),
                'data_tmdb' => $this->HTTPConnectApiTMDBMovieData($movie),  // Llamando al metodo para buscar en la API
            ];
        }

        return $moviesAsArray;
    }

    public function HTTPConnectApiTMDBMovieData($moviesid)
    {
        $moviescache = $moviesid->getThemoviedb();  // Variable para la cache
        $moviesidtmdb = $moviesid->getTmdbid();  // ID en el API de la movie

        if ($moviesidtmdb != '')  // Verificando si esta el ID del API de la movie
        {
            if (is_null($moviescache))  // Verificando si no esta almacenada en cache
            {
                $resapirestmdb = json_decode(  // Almacenando los datos buscados en la API
                    @file_get_contents(
                        "http://api.themoviedb.org/3/movie/".$moviesidtmdb."?api_key=".$_ENV['ID_API_TMDB']
                    ),
                    true
                );

                // if ($resapirestmdb !== false)
                // {
                // }
                // if ($resapirestmdb === false)
                // {
                //     $resapirestmdb = json_decode('Data Less');
                // }

                return $resapirestmdb;
            }
            if (is_null($moviescache) == false )
            {
                $resapirestmdb = [
                    'title' => $moviescache->getTitle(),
                    'release_date' => $moviescache->getReleaseDate(),
                    'backdrop_path' => $moviescache->getBackdropPath(),
                    'poster_path' => $moviescache->getPosterPath()
                ];

                return $resapirestmdb;
            }
        }
        if ($moviesidtmdb == '')
        {
            return 'Data Less';
        }
    }


    // public function functionPersistMoviesCache($moviesdb, $moviesgetAPI)
    // {
    //     $moviescache = new Themoviedb;
    //     $moviescache->setTitle($moviesgetAPI['title']);
    //     $moviescache->setReleaseDate($moviesgetAPI['release_date']);
    //     $moviescache->setBackdropPath($moviesgetAPI['backdrop_path']);
    //     $moviescache->setPosterPath($moviesgetAPI['poster_path']);
    //     $moviescache->setIdmovie($moviesdb);

    //     $em = $this->getDoctrine()->getManager();
    //     $em->persist($moviescache);
    //     $em->flush();
    // }

}