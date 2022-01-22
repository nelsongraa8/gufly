<?php

namespace App\Controller\Utils;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HeaderMethodService extends AbstractController
{
    public function __construct()
    {
        if ('prod' === $_ENV['APP_ENV']) {
            header('
                Access-Control-Allow-Origin:' . $_ENV['CLIENT_URL'] . '
            ');
            header('
                Access-Control-Allow-Headers: X-API-KEY,
                Origin,
                X-Requested-With,
                Content-Type,
                Accept,
                Access-Control-Request-Method
            ');
            header('
                Access-Control-Allow-Methods: GET,
                POST,
                OPTIONS,
                PUT,
                DELETE
            ');
            header('
                Allow: GET,
                POST,
                OPTIONS,
                PUT,
                DELETE
            ');
        }
    }
}
