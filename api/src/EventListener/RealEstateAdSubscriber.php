<?php

namespace App\EventListener;

use App\Entity\RealEstateAd;
use App\Service\Imgur;
use App\Repository\RealEstateAdRepository;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;



class RealEstateAdSubscriber implements EventSubscriberInterface {
  private RealEstateAdRepository $realEstateAdRepository;
  private $imgur;

  public function __construct(RealEstateAdRepository $realEstateAdRepository) {
    $this->realEstateAdRepository = $realEstateAdRepository;
    $this->imgur = new Imgur();
  }

  public function getSubscribedEvents(): array {
    return [
      Events::prePersist,
    ];
  }

  public function prePersist(LifecycleEventArgs $args): void {
    $object = $args->getObject();

    /** @var RealEstateAd $object */
    if ($object instanceof RealEstateAd) {
      $photos = $object->getPhotos();

      $imgurPhotos = array();

      // Upload photos to Imgur
      foreach ($photos as $photo) {
        $imgurResponse = $this->imgur->upload($photo);
        array_push($imgurDocuments, $imgurResponse);
      }

      $object->setPhotos($imgurDocuments);
      $object->setCreatedAt(new \DateTime());
      $object->setUpdatedAt(new \DateTime());
    }
  }
}
