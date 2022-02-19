<?php

namespace App\Service\Movie;

use App\Entity\Themoviedb;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\HttpClient\HttpClientService;

class HTTPConnectAPITMDBMovieDataService
{
    private $moviesid; // Objeto que representa la DB
    private $moviescache; // Variable para la cache
    private $moviesidtmdb; // ID en el API de la movie
    private $resapirestmdb; // Array donde estan los datos de la(s) movies que se quieren mostrar

    protected $doctrineManager;
    protected $httpClientService;

    public function __construct(
        ManagerRegistry $doctrineManager,
        HttpClientService $httpClientService
    ) {
        $this->doctrineManager = $doctrineManager;
        $this->httpClientService = $httpClientService;
    }

    /**
     * Metodo de entrada de esta clase
     *
     * @param [object] $moviesid
     * @return array
     */
    public function methodService($moviesid): array
    {
        $this->moviesid     = $moviesid;
        $this->moviescache  = $moviesid->getThemoviedb();
        $this->moviesidtmdb = $moviesid->getTmdbid();

        /**
         * Verificando si esta el ID de TheMovieDB
         */
        if ('' !== $this->moviesidtmdb) {
            return $this->methodForMovieInDB();
        }
        if ('' === $this->moviesidtmdb) {
            return ['Data Less'];
        }
    }

    /**
     * Verificando si no esta almacenada en cache
     */
    private function methodForMovieInDB(): array
    {
        if (true === is_null($this->moviescache)) {
            return $this->methodHTTPConnectAPI();
        }
        if (false === is_null($this->moviescache)) {
            return $this->methodDevolutionDataCacheMovieAPI();
        }
    }

    /**
     * Buscando los datos de la movie en la API
     */
    private function methodHTTPConnectAPI(): array
    {
        try {
            $this->resapirestmdb = $this->httpClientService
                ->fetchGitHubInformation(
                    $this->moviesidtmdb
                );

            $this->methodSaveDataCacheMovieAPI(); // Guardando los datos en la cache de la DB

            return $this->resapirestmdb;
        } catch (\Exception $e) {
            $this->resapirestmdb = ['Data Less'];

            return $this->resapirestmdb;
        }
    }

    /**
     * Buscando los datos de la pelicula almacenados en la DB en foma de Cache
     */
    private function methodDevolutionDataCacheMovieAPI(): array
    {
        $resapirestmdb = [
            'title'         => $this->moviescache->getTitle(),
            'release_date'  => $this->moviescache->getReleaseDate(),
            'backdrop_path' => $this->moviescache->getBackdropPath(),
            'poster_path'   => $this->moviescache->getPosterPath()
        ];

        return $resapirestmdb;
    }

    public function methodSaveDataCacheMovieAPI(): void
    {
        $moviesdb = $this->moviesid;
        $moviesgetAPI = $this->resapirestmdb;

        $moviescache = new Themoviedb();
        $moviescache->setTitle($moviesgetAPI['title']);
        $moviescache->setReleaseDate($moviesgetAPI['release_date']);
        $moviescache->setBackdropPath($moviesgetAPI['backdrop_path']);
        $moviescache->setPosterPath($moviesgetAPI['poster_path']);
        $moviescache->setIdmovie($moviesdb);

        $em = $this->doctrineManager
            ->getManager();
        $em->persist($moviescache);
        $em->flush();
    }
}
