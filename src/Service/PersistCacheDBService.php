<?php

namespace App\Service;

use App\Entity\Themoviedb;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PeristCacheDBMovieService extends AbstractController
{
    public function functionPersistMoviesCache($moviesdb, $moviesgetAPI)
    {
        $moviescache = new Themoviedb;
        $moviescache->setTitle($moviesgetAPI['title']);
        $moviescache->setReleaseDate($moviesgetAPI['release_date']);
        $moviescache->setBackdropPath($moviesgetAPI['backdrop_path']);
        $moviescache->setPosterPath($moviesgetAPI['poster_path']);
        $moviescache->setIdmovie($moviesdb);

        $em = $this->getDoctrine()->getManager();
        $em->persist($moviescache);
        $em->flush();
    }
}