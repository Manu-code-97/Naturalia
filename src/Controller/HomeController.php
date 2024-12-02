<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use App\Repository\RecetteRepository;
use PhpParser\Node\Expr\Cast\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    // affichage de la page d'accueil du site 
    
    #[Route('/', name: 'app_home')]
    public function index(ProduitRepository $produitRepository,RecetteRepository $recetteRepository): Response
    {
         /*affichage des produits en promotions, ainsi que les recettes du jour qui sont affichées de façon aleatoire selon le propriétaire (route commune (/)) et une fonction index avec deux parametres.*/

        $productsPromo= $produitRepository->getProductsOnPromotion();
        $hasPromotion = !empty($productsPromo); // gerer le cas ou il ya pas eu de promotion
       
        // declarer une variable pour recuperer une recette au pif au faisant appele a ma fonction
        $listeRecettes = $recetteRepository->findRandomRecipe();
        $randomRecette = $listeRecettes[rand(0,count($listeRecettes)-1)];
        //dd($randomRecette); //pour tester la'ffichage des produits en promo
            
        return $this->render('home/index.html.twig', [
          // variable  A recuperer pour Afficher la vue des produits en  promotions 
            'productsPromo' => $productsPromo,   
            'hasPromotion' => $hasPromotion, // à gerer dans le twig
            
        // afficher la liste des tous les produits qui sont promotions 
            'recetteDuJour' => $randomRecette
        ]);

// route pour afficher la page d'une recette en particulier une fois afficher la recette  
        #[Route('/recette', name: 'app_home_Onrecette')]
        function recetteUnique():Response
        {

                  
        return $this->render('home/recette/index.html.twig', [ ]);
  

        }
    }







}
