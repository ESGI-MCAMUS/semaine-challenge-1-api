<?php
// api/src/Controller/CreateBookPublication.php
namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\MessagesRepository;
use App\Repository\PaymentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[AsController]
class UsersPayments extends AbstractController {

  private Security $security;
  private PaymentsRepository $paymentsRepository;


  public function __construct(Security $security, PaymentsRepository $paymentsRepository) {
    $this->security = $security;
    $this->paymentsRepository = $paymentsRepository;
  }

  #[Route(
    name: 'get_payments',
    path: '/payments/get',
    methods: ['POST'],
    defaults: [
      '_api_operation_name' => '_api_/payments/get',
      '_api_description' => 'Get user payments',
    ],
  )]

  public function __invoke(): Response {
    $user = $this->security->getUser();
    $payments = $this->paymentsRepository->findBy(['debited_user_id' => $user->getId()]);

    return $this->json(['payments' => $payments]);
  }
}
