<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    // affichage de la page d'accueil du site 
    
    #[Route('/', name: 'app_home')]
    public function index(ProduitRepository $produitRepository): Response
    {

        $productsPromo= $produitRepository->getProductsOnPromotion();
        $hasPromotion = !empty($productsPromo); // gerer le cas ou i ya eu de promotion
       /*  $recettes = $recetteRepository->findRandomRecipes; */
      //dd($hasPromotion); //pour tester la'ffichage des produits en promo
            
        return $this->render('home/index.html.twig', [
          
            'productsPromo' => $productsPromo,   // variable  A recuperer pour Afficher la vue des produits en  promotions 
            'hasPromotion' => $hasPromotion, // à gerer dans le twig
            
           /* 'recettes' => $recettes //afficher la liste des tous les produits qui sont promotions */
            
        ]);
  
    }
}
