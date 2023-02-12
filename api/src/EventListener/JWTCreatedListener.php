<?php

namespace App\EventListener;

use App\Entity\User;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTCreatedListener {
    /**
     * @var RequestStack
     */
    private $requestStack;
    private $userRepository;

    public function __construct(RequestStack $requestStack) {
        $this->requestStack = $requestStack;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event): void {

        $user = $event->getUser();

        $payload['id'] = $user->getId();
        $payload['username'] = $user->getEmail();
        $payload['role'] = $user->getRoles();
        $payload['firstname'] = $user->getFirstname();
        $payload['lastname'] = $user->getLastname();
        $payload['isActive'] = $user->getIsActive();

        $event->setData($payload);
    }
}
