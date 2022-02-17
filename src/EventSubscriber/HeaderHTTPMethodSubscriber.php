<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class HeaderHTTPMethodSubscriber implements EventSubscriberInterface
{
    public function onControllerEvent(ControllerEvent $event)
    {
        $jsonResponseGeneralMovieController = new JsonResponse();

        $jsonResponseGeneralMovieController->headers
            ->set(
                'Content-Type',
                'application/json'
            );

        $jsonResponseGeneralMovieController->headers
            ->set(
                'Access-Control-Allow-Origin',
                $_ENV['CLIENT_URL']
            );

        $jsonResponseGeneralMovieController->headers
            ->set(
                'Access-Control-Allow-Headers',
                'X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method'
            );

        $jsonResponseGeneralMovieController->headers
            ->set(
                'Access-Control-Allow-Methods',
                'GET, POST, OPTIONS, PUT, DELETE'
            );

        $jsonResponseGeneralMovieController->headers
            ->set(
                'Allow',
                'GET, POST, OPTIONS, PUT, DELETE'
            );
    }

    public static function getSubscribedEvents()
    {
        return [
            ControllerEvent::class => 'onControllerEvent',
        ];
    }
}
