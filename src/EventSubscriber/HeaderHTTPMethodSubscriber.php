<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class HeaderHTTPMethodSubscriber implements EventSubscriberInterface
{
    public function onControllerEvent(ControllerEvent $event)
    {
        $jsonresponse = new JsonResponse();
        $jsonresponse->headers->set('Content-Type', 'application/json');
        $jsonresponse->headers->set('Access-Control-Allow-Origin', '*');
    }

    public static function getSubscribedEvents()
    {
        return [
            ControllerEvent::class => 'onControllerEvent',
        ];
    }
}
