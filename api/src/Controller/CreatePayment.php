<?php
// api/src/Controller/CreateBookPublication.php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Payments;
use App\Repository\HousingRepository;
use App\Repository\PaymentsRepository;
use App\Repository\RealEstateAdRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AsController]
class CreatePayment extends AbstractController {

  private UserRepository $userRepository;
  private HousingRepository $housingRepository;
  private RealEstateAdRepository $realEstateAdRepository;
  private PaymentsRepository $paymentsRepository;
  private $tokenStorage;

  public function __construct(
    UserRepository $userRepository,
    TokenStorageInterface $tokenStorage,
    HousingRepository $housingRepository,
    RealEstateAdRepository $realEstateAdRepository,
    PaymentsRepository $paymentsRepository,
  ) {
    $this->userRepository = $userRepository;
    $this->tokenStorage = $tokenStorage;
    $this->housingRepository = $housingRepository;
    $this->realEstateAdRepository = $realEstateAdRepository;
    $this->paymentsRepository = $paymentsRepository;
  }

  #[Route(
    name: 'create_payment',
    path: '/payements/create/{housing}',
    methods: ['POST'],
    defaults: [
      '_api_operation_name' => '_api_/payments/create/{housing}',
      '_api_description' => 'Create payment',
    ],
  )]

  public function __invoke($housing): Response {

    $user = $this->tokenStorage->getToken()->getUser();
    $housing = $this->housingRepository->find($housing);
    $realEstateAd = $this->realEstateAdRepository->find($housing);

    $payment = new Payments();
    $payment->setDebitedUser($user);
    $payment->setHousing($housing);
    $payment->setPrice($realEstateAd->getPrice());
    $payment->setStatus("pending");
    $payment->setToken($this->generateRandomString());
    $payment->setCreatedAt(new \DateTime());
    $payment->setUpdatedAt(new \DateTime());

    $this->paymentsRepository->save($payment, true);



    \Stripe\Stripe::setApiKey($_SERVER['STRIPE_API_KEY']);

    $checkout_session = \Stripe\Checkout\Session::create([
      'payment_method_types' => ['card'],
      'line_items' => [
        [
          'price_data' => [
            'currency' => 'eur',
            'unit_amount' => intval($payment->getPrice()) * 100,
            'product_data' => [
              'name' => $realEstateAd->getTitle() . ' — ' . $realEstateAd->getType() == "rent" ? "Location" : "Vente",
              'images' => $realEstateAd->getPhotos(),
            ],
          ],
          'quantity' => 1,
        ],
      ],
      'mode' => $realEstateAd->getType() == "rent" ? "payment" : "payment",
      'success_url' =>
      $_ENV['FRONT_URL'] . '/payments/success/' . $payment->getId() . '/' . $payment->getToken(),
      'cancel_url' =>
      $_ENV['FRONT_URL'] .
        '/payments/failed/' . $payment->getId() . '/' . $payment->getToken(),
    ]);


    return $this->json(['checkout_url' => $checkout_session->url]);
  }

  function generateRandomString($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
}
