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


#[AsController]
class AskResetPassword extends AbstractController {

  private UserRepository $userRepository;
  private $sendinblueMailer;

  public function __construct(UserRepository $userRepository) {
    $this->userRepository = $userRepository;
    $this->sendinblueMailer = new SendinblueMailer();
  }

  #[Route(
    name: 'ask_reset_password',
    path: '/users/reset-password/email',
    methods: ['POST'],
    defaults: [
      '_api_operation_name' => '_api_/users/reset-password/email',
      '_api_description' => 'Ask reset password',
    ],
  )]

  public function __invoke(Request $request): Response {
    $data = json_decode($request->getContent(), true);
    $user = $this->userRepository->findOneBy(['email' => $data['email']]);
    if (!$user) {
      return $this->json(['message' => 'Unknown user'], 404);
    }

    $generatedToken = $this->userRepository->generateToken();
    $user->setToken($generatedToken);
    $this->userRepository->save($user, true);
    $this->sendinblueMailer->sendResetPasswordEmail(
      $user,
      ['firstname' => $user->getFirstname(), 'resetURL' => $_ENV['FRONT_URL'] . '/new-password/' . $user->getToken()]
    );
    return $this->json(['message' => 'Email sent'], 200);
  }
}