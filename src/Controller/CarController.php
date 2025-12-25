<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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

    #[Route('/car/delete/{id}', name: 'app_delete')]
    public function delete(int $id, CarRepository $repo, EntityManagerInterface $em): Response
    {
        $car = $repo->find($id);
        if (!$car) {
            return $this->redirectToRoute('app_home');
        }

        $em->remove($car);
        $em->flush();


        return $this->redirectToRoute('app_home');
    }

    #[Route('/car/add', name: 'app_add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($car);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('/car/add.html.twig', [
            'form' => $form
        ]);
    }
}
