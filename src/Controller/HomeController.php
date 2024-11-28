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
    public function index(ProduitRepository $repo): Response
    {

        $produitPromos= $repo->getProductsOnPromotion();
        dd ($produitPromos);  //tester l'affichage
        return $this->render('home/index.html.twig', [
          
            'produitsPromo' => $produitPromos,   // il faut penser à recuperer la variable (produitsPromo) pour afficher la liste des tous les produits qui sont promotions
        ]);
  
    }
}
