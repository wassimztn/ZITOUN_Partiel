<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Form\ConferenceType;
use App\Repository\ConferenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/conference')]
final class ConferenceController extends AbstractController
{
    #[Route(name: 'app_conference_index', methods: ['GET'])]
    public function index(ConferenceRepository $conferenceRepository): Response
    {
        $user = $this->getUser();

        if ($this->isGranted('ROLE_ADMIN')) {
            $conferences = $conferenceRepository->findAll();
        } else {
            // Médecin : seulement ses propres conférences
            $conferences = $conferenceRepository->findBy(['medecin' => $user]);
        }

        return $this->render('conference/index.html.twig', [
            'conferences' => $conferences,
        ]);
    }

    #[Route('/new', name: 'app_conference_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $conference = new Conference();
        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($conference);
            $entityManager->flush();

            return $this->redirectToRoute('app_conference_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('conference/new.html.twig', [
            'conference' => $conference,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_conference_show', methods: ['GET'])]
    public function show(Conference $conference): Response
    {
        $user = $this->getUser();

        if (!$this->isGranted('ROLE_ADMIN') && $conference->getMedecin() !== $user) {
            throw $this->createAccessDeniedException("Vous n'avez pas accès à cette conférence.");
        }

        return $this->render('conference/show.html.twig', [
            'conference' => $conference,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_conference_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Conference $conference, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_conference_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('conference/edit.html.twig', [
            'conference' => $conference,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_conference_delete', methods: ['POST'])]
    public function delete(Request $request, Conference $conference, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $submittedToken = $request->request->get('_token');
        if ($this->isCsrfTokenValid('delete'.$conference->getId(), $submittedToken)) {
            $entityManager->remove($conference);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_conference_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/pathologie/{id}', name: 'app_conference_by_pathology', methods: ['GET'])]
    public function byPathologie(int $id, ConferenceRepository $conferenceRepository): Response
    {
        // Ici on suppose que seul l'admin peut filtrer par pathologie
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $conferences = $conferenceRepository->findBy(['pathologie' => $id]);

        return $this->render('conference/index.html.twig', [
            'conferences' => $conferences,
        ]);
    }

}
