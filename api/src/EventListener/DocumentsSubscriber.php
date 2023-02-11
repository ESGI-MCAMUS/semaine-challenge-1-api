<?php

namespace App\EventListener;

use App\Entity\Documents;
use App\Repository\DocumentsRepository;
use App\Service\Imgur;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;



class DocumentsSubscriber implements EventSubscriberInterface {
  private DocumentsRepository $docmentsRepository;
  private $imgur;

  public function __construct(DocumentsRepository $docmentsRepository) {
    $this->docmentsRepository = $docmentsRepository;
    $this->imgur = new Imgur();
  }

  public function getSubscribedEvents(): array {
    return [
      Events::prePersist,
      Events::preUpdate,
    ];
  }

  public function prePersist(LifecycleEventArgs $args): void {
    $object = $args->getObject();

    /** @var Documents $object */
    if ($object instanceof Documents) {
      $documents = $object->getDocuments();

      $imgurDocuments = array();

      // Upload documents to Imgur
      foreach ($documents as $document) {
        $imgurResponse = $this->imgur->upload($document);
        array_push($imgurDocuments, $imgurResponse);
      }

      $object->setDocuments($imgurDocuments);
      $object->setCreatedAt(new \DateTime());
      $object->setUpdatedAt(new \DateTime());
    }
  }

  public function preUpdate(LifecycleEventArgs $args): void {
    $object = $args->getObject();

    /** @var Documents $object */
    if ($object instanceof Documents) {
      $documents = $object->getDocuments();

      $imgurDocuments = array();

      // Upload documents to Imgur
      foreach ($documents as $document) {
        $imgurResponse = $this->imgur->upload($document);
        array_push($imgurDocuments, $imgurResponse);
      }

      $object->setDocuments($imgurDocuments);
      $object->setUpdatedAt(new \DateTime());
    }
  }
}
