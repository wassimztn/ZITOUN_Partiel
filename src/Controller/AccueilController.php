<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    #[Route('/accueil', name: 'app_accueil')]
    public function index(): Response
    {
        // On passe éventuellement des variables au template
        return $this->render('accueil/index.html.twig', [
            'page_title' => 'Accueil',
        ]);
    }
}
