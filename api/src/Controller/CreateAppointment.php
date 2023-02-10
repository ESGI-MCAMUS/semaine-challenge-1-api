<?php

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class CreateAppointment extends AbstractController
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route(
        name: 'create_appointment',
        path: '/appointment/{housingId}',
        methods: ['POST'],
        defaults: [
            '_api_operation_name' => '_api_/appointment/{housingId}',
            '_api_description' => 'Create Appointment',
        ],
    )]
    public function __invoke(string $token): Response
    {
//        $user = $this->userRepository->findOneBy(['emailToken' => $token]);
//        if (!$user) {
//            return $this->json(['message' => 'Invalid token'], 400);
//        }
//        $user->setToken(null);
//        $user->setIsActive(true);
//        $this->userRepository->save($user, true);
//        return $this->json($user);
        return $this->json(['pouet' => 'test controller']);
    }
}
