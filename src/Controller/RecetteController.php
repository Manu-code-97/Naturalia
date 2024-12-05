<?php

namespace App\Controller;
use App\Repository\RecetteRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecetteController extends AbstractController
{
    #[Route('/recettes', name: 'allRecettes')]
    public function afficheToutesLesRecettes(RecetteRepository $recetteRepository): Response
    {
        // Récupérer une recette aléatoire
        $randomRecette = $recetteRepository->findRandomRecipe();

        // Récupérer les produits liés à cette recette
        $produitsRecette = $recetteRepository->findProductsByRecetteId($randomRecette->getId());

        return $this->render('recettes/index.html.twig', [
            'recette' => $randomRecette,
            'produits' => $produitsRecette,
        ]);
    }

    #[Route('/recettes/{recette}', name: 'uneSeuleRecette')]
    public function afficheRecette(RecetteRepository $recetteRepository, $recette): Response
    {
        // Récupérer une recette aléatoire
        $randomRecette = $recetteRepository->findRandomRecipe();

        // Récupérer les produits liés à cette recette
        $produitsRecette = $recetteRepository->findProductsByRecetteId($randomRecette->getId());

        return $this->render('recettes/index.html.twig', [
            'recette' => $randomRecette,
            'produits' => $produitsRecette,
        ]);
    }

}
