<?php

namespace App\EventListener;

use App\Entity\Appointment;
use App\Repository\AppointmentRepository;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;



class AppointmentSubscriber implements EventSubscriberInterface {
  private AppointmentRepository $appointmentRepository;


  public function __construct(AppointmentRepository $appointmentRepository) {
    $this->appointmentRepository = $appointmentRepository;
  }

  public function getSubscribedEvents(): array {
    return [
      Events::prePersist,
    ];
  }

  public function prePersist(LifecycleEventArgs $args): void {
    $object = $args->getObject();

    // Check if user has already an appintment for this housing
    if ($object instanceof Appointment) {
      $visitor = $object->getVisitor();
      $housing = $object->getHousing();

      $appointment = $this->appointmentRepository->findOneBy([
        'visitor' => $visitor,
        'housing' => $housing,
      ]);

      if ($appointment) {
        throw new \Exception('User already has an appointment for this housing');
      }

      // Check if there is already an appointment for this housing at this date
      $date = $object->getDate();

      $appointment = $this->appointmentRepository->findOneBy([
        'housing' => $housing,
        'date' => $date,
      ]);

      if ($appointment) {
        throw new \Exception('There is already an appointment for this housing at this date');
      }
    }
  }
}
