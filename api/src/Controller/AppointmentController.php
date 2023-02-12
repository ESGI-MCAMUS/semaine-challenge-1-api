<?php
// api/src/Controller/CreateBookPublication.php
namespace App\Controller;

use App\Entity\User;
use App\Repository\AppointmentRepository;
use App\Repository\HousingRepository;
use App\Repository\UserRepository;
use App\Repository\MessagesRepository;
use App\Repository\PaymentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[AsController]
class AppointmentController extends AbstractController {

    private Security $security;
    private AppointmentRepository $appointmentRepository;
    private HousingRepository $housingRepository;


    public function __construct(Security $security, AppointmentRepository $appointmentRepository, HousingRepository $housingRepository) {
        $this->security = $security;
        $this->appointmentRepository = $appointmentRepository;
        $this->housingRepository = $housingRepository;
    }

    #[Route(
        name: 'get_appointments',
        path: '/appointments/get',
        methods: ['POST'],
        defaults: [
            '_api_operation_name' => '_api_/appointments/get',
            '_api_description' => 'Get user appointments',
        ],
    )]

    public function __invoke(): Response {
        $user = $this->security->getUser();

        $housings = $this->housingRepository->findBy(['owner' => $user->getId()]);

        $ownerAppointments = [];
        foreach ($housings as $housing) {
            $ownerAppointments[] = $this->appointmentRepository->findBy(['housing' => $housing->getId()]);
        }

        $visitorAppointments = $this->appointmentRepository->findBy(['visitor' => $user->getId()]);

        return $this->json(['ownerAppointments' => $ownerAppointments, 'visitorAppointments' => $visitorAppointments]);
    }
}
