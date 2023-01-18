<?php
// api/src/Controller/CreateBookPublication.php
namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class VerifyEmail extends AbstractController {

  private UserRepository $userRepository;

  public function __construct(UserRepository $userRepository) {
    $this->userRepository = $userRepository;
  }

  #[Route(
    name: 'verify_email',
    path: '/users/verify/{token}',
    methods: ['POST'],
    defaults: [
      '_api_operation_name' => '_api_/users/verify/{token}',
      '_api_description' => 'Verify email',
    ],
  )]

  public function __invoke(string $token): Response {
    $user = $this->userRepository->findOneBy(['emailToken' => $token]);
    if (!$user) {
      return $this->json(['message' => 'Invalid token'], 400);
    }
    $user->setToken(null);
    $user->setIsActive(true);
    $this->userRepository->save($user, true);
    return $this->json($user);
  }
}