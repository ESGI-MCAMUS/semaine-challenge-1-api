<?php

namespace App\EventListener;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Service\SendinblueMailer;



class UserSubscriber implements EventSubscriberInterface {
  private UserRepository $userRepository;
  private $sendinblueMailer;

  public function __construct(private UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository) {
    $this->userRepository = $userRepository;
    $this->sendinblueMailer = new SendinblueMailer();
  }

  public function getSubscribedEvents(): array {
    return [
      Events::prePersist,
      Events::preUpdate,
    ];
  }

  public function prePersist(LifecycleEventArgs $args): void {
    $object = $args->getObject();

    /** @var User $object */
    if ($object instanceof User) {
      $this->updatePwd($object);
      $object->setToken($this->userRepository->generateToken());
      $object->setRoles(['ROLE_USER']);
      $this->sendinblueMailer->sendEmail($object, ['firstname' => $object->getFirstname(), 'confirmationUrl' => $_ENV['FRONT_URL'] . '/confirm/' . $object->getToken()]);
    }
  }

  public function preUpdate(LifecycleEventArgs $args): void {
    $object = $args->getObject();
    /** @var User $object */
    if ($object instanceof User) {
      $this->updatePwd($object);
    }
  }

  private function updatePwd(User $object): void {
    if ($object->getPlainPassword()) {
      $object->setPassword($this->passwordHasher->hashPassword($object, $object->getPlainPassword()));
    }
  }
}