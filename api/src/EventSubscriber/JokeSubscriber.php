<?php

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\Joke;
use App\Entity\Rate;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class JokeSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW =>   ['setAverageOnGet', EventPriorities::PRE_SERIALIZE]
        ];
    }

    public function setAverageOnGet(ViewEvent $event) {
        /** @var Joke $joke */
        $joke = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$joke instanceof Joke || Request::METHOD_GET !== $method) {
            return;
        }

        /** @var Rate $currentRate */
        $total = 0;
        foreach ($joke->getRates() as $currentRate) {
            $total += $currentRate->getStar();
        }

        $joke->setAvarage($total/count($joke->getRates()));
    }
}
