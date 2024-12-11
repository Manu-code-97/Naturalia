<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CheckOutController extends AbstractController
{
    #[Route('/check/out', name: 'app_check_out')]
    public function index(): Response
    {
        return $this->render('checkout/index.html.twig', [
            'controller_name' => 'CheckOutController',
        ]);
    }


    #[Route('/panier/paiement', name: 'app_panier_paiement')]
    public function panierPaiement(): Response
    {
        return $this->render('checkout/delivery.html.twig', [
            'controller_name' => 'CheckOutController',
        ]);
    }



    #[Route('/confirmation', name: 'app_confirmation')]
    public function confirmation(): Response
    {
        return $this->render('checkout/confirmation.html.twig', [
            'controller_name' => 'CheckOutController',
        ]);
    }
}
