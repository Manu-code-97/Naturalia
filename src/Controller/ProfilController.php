<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ProfilController extends AbstractController
{
    
    
    #[Route('/profil', name: 'app_profil')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
        ]);

    }

    #[Route('/profil/favoris', name: 'app_profil_favoris')]
    #[IsGranted('ROLE_USER')]
    public function favori(): Response
    {
        return $this->render('profil/favoris.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
        
    }

    #[Route('/profil/mes-commande', name: 'app_profil_commande')]
    #[IsGranted('ROLE_USER')]
    public function commande(): Response
    {
        return $this->render('profil/historique.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
        
    }
}
