<?php
// api/src/Controller/CreateBookPublication.php
namespace App\Controller;

use App\Repository\PaymentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class UpdatePaymentStatus extends AbstractController {

  private PaymentsRepository $paymentsRepository;

  public function __construct(
    PaymentsRepository $paymentsRepository,
  ) {
    $this->paymentsRepository = $paymentsRepository;
  }

  #[Route(
    name: 'update_payment_status',
    path: '/payments/{status}/{id}/{token}',
    methods: ['POST'],
    defaults: [
      '_api_operation_name' => '_api_/payments/{status}/{id}/{token}',
      '_api_description' => 'Update payment status',
    ],
  )]

  public function __invoke($status, $id, $token): Response {

    // Get the payment by is and token
    $payment = $this->paymentsRepository->findOneBy(['id' => $id, 'token' => $token]);

    // If the payment is not found, return an error
    if (!$payment) {
      return $this->json(['error' => 'Payment not found'], 404);
    }

    // If the payment is already paid, return an error
    if ($payment->getStatus() == "success" || $payment->getStatus() == "failed") {
      return $this->json(['error' => 'Payment already processed'], 400);
    }

    // Set the payment status to failed
    $payment->setStatus($status);
    $payment->setUpdatedAt(new \DateTime());

    // Save the payment
    $this->paymentsRepository->save($payment, true);

    return $this->json([$payment]);
  }
}
