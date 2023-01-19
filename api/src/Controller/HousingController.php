<?php

namespace App\Controller;

use App\Repository\HousingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;


#[AsController]
class HousingController
{
    private $housingRepository;

    public function __construct(HousingRepository $housingRepository)
    {
        $this->housingRepository = $housingRepository;
    }

    #[Route(
        name: 'housing_list',
        path: '/users/house-filters',
        methods: ['GET'],
        defaults: [
            '_api_operation_name' => '_api_/housings/house-filters',
            '_api_description' => 'house filters',
        ],
    )]


    public function __invoke(Request $request)
    {
        $filter = $request->query->get('filter');
        return $this->housingRepository->findByFilter($filter);
    }
}
