<?php

namespace App\Service;

use App\Entity\Themoviedb;
#use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormatSalidaJSONMovieService
{
    /**
     * Formateo de la salida de un array en JSON, en llamado desde cada metodo de este controlador
     */
    public function FormatSalidaMovieArrayJSON($movies_data)
    {
        /**
         * movies hay que transformarlo en un array para despues mostrarlo en un JSON
         */
        $moviesAsArray = [];
        foreach ($movies_data as $movie) {
            // $this->methodForMoviesArrayFormat( $moviesingle );
            $moviesAsArray[] = [
                'id' => $movie->getId(),
                'tmdbid' => $movie->getTmdbid(),
                'nombre' => $movie->getNombre(),
                'anno' => $movie->getAnno(),
                'url' => $movie->getUrl(),
                'url_subtitulo' => $movie->getUrlSubtitulo(),
                'data_tmdb' => $this->HTTPConnectApiTMDBMovieData($movie),
            ];
        }

        return $moviesAsArray;
    }

    // public function methodForMoviesArrayFormat( $movie )
    // {
    //     $moviesAsArray[] = [
    //         'id' => $movie->getId(),
    //         'tmdbid' => $movie->getTmdbid(),
    //         'nombre' => $movie->getNombre(),
    //         'anno' => $movie->getAnno(),
    //         'url' => $movie->getUrl(),
    //         'url_subtitulo' => $movie->getUrlSubtitulo(),
    //         'data_tmdb' => $this->HTTPConnectApiTMDBMovieData($movie),
    //     ];
    // }


    public function HTTPConnectApiTMDBMovieData($moviesid)
    {
        $moviescache = $moviesid->getThemoviedb();
        $moviesidtmdb = $moviesid->getTmdbid();

        if ( $moviesidtmdb != '') {
            if (!$moviescache) {
                $resapirestmdb = json_decode(
                    @file_get_contents("http://api.themoviedb.org/3/movie/" . $moviesidtmdb . "?api_key=".$_ENV['ID_API_TMDB']),
                    true
                );

                if ($resapirestmdb !== false) {
                    //$this->functionPersistMoviesCache($moviesid, $resapirestmdb);
                }
                if ($resapirestmdb === false) {
                    $resapirestmdb = json_decode('Data Less');
                }

                return $resapirestmdb;
            } else {
                $resapirestmdb = [
                    'title' => $moviescache->getTitle(),
                    'release_date' => $moviescache->getReleaseDate(),
                    'backdrop_path' => $moviescache->getBackdropPath(),
                    'poster_path' => $moviescache->getPosterPath()
                ];
            }
        }

        if($moviesid->getTmdbid() == '') {
            return 0;
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