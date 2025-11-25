<?php

namespace App\Controller;

use App\Entity\Pathologie;
use App\Form\PathologieType;
use App\Repository\PathologieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/pathologie', name: 'app_pathologie_')]
final class PathologieController extends AbstractController
{
    #[Route(name: 'index', methods: ['GET'])]
    public function index(PathologieRepository $pathologieRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('pathologie/index.html.twig', [
            'pathologies' => $pathologieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $pathologie = new Pathologie();
        $form = $this->createForm(PathologieType::class, $pathologie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pathologie);
            $entityManager->flush();

            return $this->redirectToRoute('app_pathologie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pathologie/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Pathologie $pathologie): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('pathologie/show.html.twig', [
            'pathologie' => $pathologie,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pathologie $pathologie, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(PathologieType::class, $pathologie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_pathologie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pathologie/edit.html.twig', [
            'pathologie' => $pathologie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Pathologie $pathologie, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$pathologie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($pathologie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_pathologie_index', [], Response::HTTP_SEE_OTHER);
    }
}
