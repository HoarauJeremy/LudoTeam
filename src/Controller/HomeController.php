<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {

        // $this->denyAccessUnlessGranted('ROLES_USER');

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route(path:'/api', name:'app_evenement_api', methods: ['GET'])]
    public function getEvenements(SerializerInterface $serializer, EvenementRepository $evenement): JsonResponse
    {
        $data = $serializer->serialize($evenement->findAll(), 'json', ['groups' => 'evenement:list']);

        return $this->json([
            'messages' => "Success",
            'code' => 200,
            'data' => json_decode($data)
        ], 200);
    }
}
