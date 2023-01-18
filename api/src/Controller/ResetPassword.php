<?php
// api/src/Controller/CreateBookPublication.php
namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\SendinblueMailer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


#[AsController]
class ResetPassword extends AbstractController {

  private UserRepository $userRepository;

  public function __construct(UserRepository $userRepository, private readonly UserPasswordHasherInterface $passwordHasher) {
    $this->userRepository = $userRepository;
  }

  #[Route(
    name: 'reset_password',
    path: '/users/reset-password',
    methods: ['POST'],
    defaults: [
      '_api_operation_name' => '_api_/users/reset-password',
      '_api_description' => 'Reset password',
    ],
  )]

  public function __invoke(Request $request): Response {
    $data = json_decode($request->getContent(), true);
    $user = $this->userRepository->findOneBy(['emailToken' => $data['token']]);
    if (!$user) {
      return $this->json(['message' => 'Unknown user'], 404);
    }

    $hashedPassword = $this->passwordHasher->hashPassword($user, $data['plainPassword']);
    $user->setPassword($hashedPassword);
    $user->setToken(null);
    $this->userRepository->save($user, true);
    return $this->json([$user], 200);
  }
}