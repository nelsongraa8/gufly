<?php

namespace App\Service\HttpClient;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpClientService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetchGitHubInformation($moviesidtmdb): array
    {
        $response = $this->client->request(
            'GET',
            'http://api.themoviedb.org/3/movie/'
            . $moviesidtmdb . '?api_key='
            . $_ENV["ID_API_TMDB"]
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        return $content;
    }
}
