<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class HeaderHTTPMethodSubscriber implements EventSubscriberInterface
{
    public function onControllerEvent(ControllerEvent $event)
    {
        if ('test' != $_ENV['APP_ENV']) {
            header('Access-Control-Allow-Origin:' . $_ENV['CLIENT_URL']);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            ControllerEvent::class => 'onControllerEvent',
        ];
    }
}
