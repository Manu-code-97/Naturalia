<?php

namespace App\Controller; 

use App\Repository\ProduitRepository; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\Routing\Annotation\Route; 
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController 
{ 
    #[Route('/product', name: 'app_product')] 
    public function showProduct(ProduitRepository $repo): Response { 
        
        $products = $repo->findAll(); 
        return $this->render('product/index.html.twig', 
        [ 'products' => $products, ]); 
    } 
    
    #[Route('/{category}/{sousCategory}/{product}', name: 'app_sous_category_products')]
    public function sousCategory (ProduitRepository $repo , $sousCategory): Response{
        $products = $repo -> findProductsBySousCategory($sousCategory);
        $productsPromos = $repo -> getProductsOnPromotion();
        //dd ($products);
        return $this->render('product/index.html.twig', 
        [ 'products' => $products, 
        'productsPromos' => $productsPromos,  ]); 
    }

    #[Route('/products', name: 'product_list')]
    public function list(ProduitRepository $repo, PaginatorInterface $paginator, Request $request): Response 
    {
        $queryBuilder = $repo->createQueryBuilder('p');

        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page ', 1 ),
            10
        );
        dump($pagination);
        return $this->render('product/index.html.twig', [
        'pagination' => $pagination,
        ]);
    }
}

