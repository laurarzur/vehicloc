<?php

namespace App\Controller;

use App\Entity\Car;
use App\Repository\CarRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CarController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CarRepository $repo): Response
    {
        $cars = $repo->findAll();

        return $this->render('home.html.twig', [
            'cars' => $cars,
        ]);
    }

    #[Route('/car/{id}', name: 'app_car', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function carDetail(?Car $car): Response
    {
        if (!$car) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('/car/index.html.twig', [
            'car' => $car,
        ]);
    }
}
