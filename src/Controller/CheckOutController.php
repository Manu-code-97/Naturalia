<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use App\Repository\MagasinRepository;
use App\Repository\CalculDistanceMag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CheckOutController extends AbstractController
{
    #[Route('/panier', name: 'app_check_out')]
    public function index(ProduitRepository $repo ): Response
    {

        $productsSelection = $repo -> aleatProducts(20);
 
        ;

        return $this->render('checkout/index.html.twig', [
            'controller_name' => 'CheckOutController',
        
        'productsSelection' => $productsSelection, 

        ]);
    }
    
    #[Route('/panier/livraison/{cp}', name: 'app_panier_livraison')]
    public function panierLivraison(MagasinRepository $repo, CalculDistanceMag $calc, $cp): Response
    {   
        $magasinsDB = $repo->getAllStores();
        // dd($magasins);
        $magasins = $calc->calculDistance($magasinsDB, $cp);

        return $this->render('checkout/delivery.html.twig', [
            'magasins' => $magasins
        ]);
    }

    #[Route('/panier/paiement', name: 'app_panier_paiement')]
    #[IsGranted('ROLE_USER')]
    public function panierPaiement(ProduitRepository $repo): Response
    {
        //$products = $repo->findProductsOfSousCategory($livraison);
        $products = $repo->createQueryBuilder('p')
        ->getQuery()
        ->getResult();

        return $this->render('checkout/paiementDelivery.html.twig', [
            'controller_name' => 'CheckOutController',
            'products' => $products,
        ]);
    }


    #[Route('/confirmation', name: 'app_confirmation')]
    #[IsGranted('ROLE_USER')]
    public function confirmation(): Response
    {
        return $this->render('checkout/confirmation.html.twig', [
            'controller_name' => 'CheckOutController',
        ]);
    }
}
