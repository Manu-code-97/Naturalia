<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function showProduct(ProduitRepository $repo, $products): Response
    {
        $products = $repo->findAll(); 
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/{produit}', name: 'app_product_{product}')]
    public function product(ProduitRepository $repos, $product): Response
    {
        $product = $repos->find($product);
    }
}
