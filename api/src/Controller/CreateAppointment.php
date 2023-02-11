<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[AsController]
class CreateAppointment extends AbstractController
{

    private UserRepository $userRepository;
    private Security $security;

    public function __construct(Security $security, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->security = $security;
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
    public function __invoke($housingId): Response
    {
        $user = $this->security->getUser();

        if (!$user) {
            return $this->json([
                'error' => 'User not logged in',
            ], 403);
        }

        $appointments = $this->userRepository->find($user->getId())->getAppointments();
        foreach ($appointments as $appointment) {
            if ($appointment->getHousing()->getId() == $housingId) {
                return $this->json([
                    'error' => 'User already has an appointment for this housing',
                ], 400);
            }
        }

        return $this->json(['appointments' => $appointments, "housing", $housingId], 200);
    }
}
