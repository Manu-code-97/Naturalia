<?php

namespace App\Controller; 

use App\Repository\ProduitRepository; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\Routing\Annotation\Route; 

class ProductController extends AbstractController 
{ 
    #[Route('/product', name: 'app_product')] 
    public function showProduct(ProduitRepository $repo): Response { 
        
        $products = $repo->findAll(); 
        return $this->render('product/index.html.twig', 
        [ 'products' => $products, ]); 
    } 
    
    #[route('/product/{sousCategory}')]
    public function sousCategory (ProduitRepository $repo , $sousCategory): Response{
        $products = $repo -> findProductsBySousCategory($sousCategory);
        //dd ($products);
        return $this->render('product/index.html.twig', 
        [ 'products' => $products, ]); 
    }

    /* #[Route('/product/{product}', name: 'app_product_show')] 
    public function product(ProduitRepository $repo, $product): Response { 
        
        $product = $repo->find($product); 
        return $this->render('product/index.html.twig', 
        [ 'product' => $product, ]); 
    }  */
}
