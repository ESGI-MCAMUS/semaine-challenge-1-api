<?php

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\Rate;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class RateSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['setRatesTotalOnJoke', EventPriorities::PRE_WRITE]
        ];
    }

    public function setRatesTotalOnJoke(ViewEvent $event): void
    {
        /** @var Rate $rate */
        $rate = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$rate instanceof Rate || Request::METHOD_POST !== $method) {
            return;
        }

        $joke = $rate->getJoke();

        /** @var Rate $currentRate */
        $total = $rate->getStar();
        foreach ($joke->getRates() as $currentRate) {
            $total += $currentRate->getStar();
        }

        $rate->getJoke()->setRatesTotal($total/count($joke->getRates()));
    }
}
