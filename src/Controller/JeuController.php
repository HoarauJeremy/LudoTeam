<?php

namespace App\Controller;

use App\Entity\Carte;
use App\Entity\Duel;
use App\Entity\Jeu;
use App\Entity\Plateau;
use App\Form\JeuType;
use App\Repository\CarteRepository;
use App\Repository\DuelRepository;
use App\Repository\JeuRepository;
use App\Repository\PlateauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/jeu')]
final class JeuController extends AbstractController
{

    private $plateau;
    private $carte;
    private $duel;

    function __construct(PlateauRepository $plateauRepository,CarteRepository $carteRepository, DuelRepository $duelRepository)
    {
        $this->plateau = $plateauRepository;
        $this->carte = $carteRepository;
        $this->duel = $duelRepository;
    }

    #[Route(name: 'app_jeu_index', methods: ['GET'])]
    public function index(JeuRepository $jeuRepository, Request $request): Response
    {
        // $this->denyAccessUnlessGranted('ROLES_USER');

        $nom = $request->query->get('nom');
        $nbParticipant = $request->query->get('nbParticipant');
        $type = $request->query->get('type');


        if ($nom !== null && $nbParticipant !== null && $type !== null) {
            
            $nom = $nom !== null ? (string)$nom : null;
            $nbParticipant = $nbParticipant !== null ? (int)$nbParticipant : null;
            $type = $type !== null ? (string)$type : null;
            
            if ($type !== null) {
                
                if ($type === 'plateau') {
                    $data = $this->plateau->findAll();
                }
                
                if ($type === 'carte') {
                    $data = $this->carte->findAll();
                }
                
                if ($type === 'duel') {
                    $data = $this->duel->findAll();
                }
            } else {
                $data = $jeuRepository->findByFiltre($nom, $nbParticipant);
            }
        } else {
            $data = $jeuRepository->findAll();
        }
        
        return $this->render('jeu/index.html.twig', [
            'jeus' => $data,
        ]);
    }

    #[Route('/new', name: 'app_jeu_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // $this->denyAccessUnlessGranted('ROLES_USER');

        $jeu = new Jeu();
        $form = $this->createForm(JeuType::class, $jeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $type = $form->get('type')->getData();

            if ($type === 'Plateau') {
                $jeu = new Plateau();
                $jeu->setNbDes(4);
            } elseif ($type === 'Carte') {
                $jeu = new Carte();
                $jeu->setNbCarte(52);
            } elseif ($type === 'Duel') {
                $jeu = new Duel();
                $jeu->setDuel(true);
            }

            if ($jeu) {
            
                $jeu->setNom($form->get('nom')->getData());
                $jeu->setNbParticipant($form->get('nbParticipant')->getData());
                $jeu->setEvenement($form->get('evenement')->getData());
                
                $entityManager->persist($jeu);
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_jeu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('jeu/new.html.twig', [
            'jeu' => $jeu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_jeu_show', methods: ['GET'])]
    public function show(Jeu $jeu): Response
    {
        // $this->denyAccessUnlessGranted('ROLES_USER');

        return $this->render('jeu/show.html.twig', [
            'jeu' => $jeu,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_jeu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Jeu $jeu, EntityManagerInterface $entityManager): Response
    {
        // $this->denyAccessUnlessGranted('ROLES_USER');

        $form = $this->createForm(JeuType::class, $jeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_jeu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('jeu/edit.html.twig', [
            'jeu' => $jeu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_jeu_delete', methods: ['POST'])]
    public function delete(Request $request, Jeu $jeu, EntityManagerInterface $entityManager): Response
    {
        // $this->denyAccessUnlessGranted('ROLES_USER');

        if ($this->isCsrfTokenValid('delete'.$jeu->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($jeu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_jeu_index', [], Response::HTTP_SEE_OTHER);
    }
}
