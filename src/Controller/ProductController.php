<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(ProduitRepository $produitRepository): Response
    {
        $produits = $produitRepository->findAll();

        return $this->render('product/index.html.twig', [
            'produits' => $produits,
            
        ]);
    }

    #[Route('/product/{produit}', name: 'app_produit')]
    public function produit(ProduitRepository $produitRepository, $produit): Response
    {
        $produit = $produitRepository->find($produit);

        return $this->render('product/show.html.twig', [
            'produit' => $produit,
        ]);
    }
}
