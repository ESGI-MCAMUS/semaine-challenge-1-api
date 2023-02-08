<?php
// api/src/Controller/CreateBookPublication.php
namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\MessagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[AsController]
class FilterMessages extends AbstractController {

  private Security $security;
  private MessagesRepository $messagesRepository;
  private UserRepository $userRepository;


  public function __construct(Security $security, MessagesRepository $messagesRepository, UserRepository $userRepository) {
    $this->security = $security;
    $this->messagesRepository = $messagesRepository;
    $this->userRepository = $userRepository;
  }

  #[Route(
    name: 'filter_messages',
    path: '/users/messages',
    methods: ['POST'],
    defaults: [
      '_api_operation_name' => '_api_/users/messages',
      '_api_description' => 'Get user messages',
    ],
  )]

  public function __invoke(): Response {
    $user = $this->security->getUser();
    $sentMessages = $this->messagesRepository->findBy(['sender' => $user->getId()]);


    // For each messages, replace sender and receiver by their user object
    $formattedSentMessages = [];
    foreach ($sentMessages as $message) {
      $tempSender = ($this->userRepository->find($message->getSender()));
      $tempReceiver = ($this->userRepository->find($message->getReceiver()));

      $formattedSentMessage = array(
        'id' => $message->getId(),
        'sender' => array(
          'id' => $tempSender->getId(),
          'firstname' => $tempSender->getFirstname(),
          'lastname' => $tempSender->getLastname(),
        ),
        'receiver' => array(
          'id' => $tempReceiver->getId(),
          'firstname' => $tempReceiver->getFirstname(),
          'lastname' => $tempReceiver->getLastname(),
        ),
        'message' => $message->getMessage(),
        'createdAt' => $message->getCreatedAt(),
        'updatedAt' => $message->getUpdatedAt(),
        'deletedAt' => $message->getDeletedAt(),
      );
      array_push($formattedSentMessages, $formattedSentMessage);
    }

    $receivedMessages = $this->messagesRepository->findBy(['receiver' => $user->getId()]);
    $formattedReceivedMessages = [];
    foreach ($receivedMessages as $message) {
      $tempSender = ($this->userRepository->find($message->getSender()));
      $tempReceiver = ($this->userRepository->find($message->getReceiver()));

      $formattedReceivedMessage = array(
        'id' => $message->getId(),
        'sender' => array(
          'id' => $tempSender->getId(),
          'firstname' => $tempSender->getFirstname(),
          'lastname' => $tempSender->getLastname(),
        ),
        'receiver' => array(
          'id' => $tempReceiver->getId(),
          'firstname' => $tempReceiver->getFirstname(),
          'lastname' => $tempReceiver->getLastname(),
        ),
        'message' => $message->getMessage(),
        'createdAt' => $message->getCreatedAt(),
        'updatedAt' => $message->getUpdatedAt(),
        'deletedAt' => $message->getDeletedAt(),
      );
      array_push($formattedReceivedMessages, $formattedReceivedMessage);
    }
    return $this->json(['sentMessages' => $formattedSentMessages, 'receivedMessages' => $formattedReceivedMessages]);
  }
}
