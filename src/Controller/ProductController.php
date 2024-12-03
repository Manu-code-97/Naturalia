<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use App\Repository\SousCategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\Routing\Annotation\Route; 
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController 
{ 
    // #[Route('/product', name: 'app_product')] 
    // public function showProduct(ProduitRepository $repo): Response { 
        
    //     $products = $repo->findAll(); 
    //     return $this->render('product/index.html.twig', 
    //     [ 'products' => $products, ]); 
    // } 
    #[Route('/{category}/{sousCategory}/', name: 'sousCatProduits')]
    public function sousCategory (ProduitRepository $repo , $sousCategory): Response{
        $products = $repo -> findProductsBySousCategory($sousCategory);
        $productsPromos = $repo -> getProductsOnPromotion();
        //dd ($products);
        return $this->render('product/index.html.twig', 
        [ 'products' => $products, 
        'productsPromos' => $productsPromos,  ]); 
    }

    #[Route('/categorie/{category}', name: 'catProduits')]
    public function categoryProduit (ProduitRepository $repo , $category): Response{
        $products = $repo -> findProductsByCategory($category);
        $productsPromos = $repo -> getProductsOnPromotion();

        //dd ($products);
        return $this->render('product/index.html.twig', 
        [ 'products' => $products, 
        'productsPromos' => $productsPromos,  ]); 
    }

   
    #[Route('/{category}/{sousCategory}/{product}', name: 'detailProduit')]
    public function detailProduit (ProduitRepository $repo , $product): Response{
        $product = $repo -> find($product);
        // $productsSelection = $repo -> getProductsOnPromotion(); // a voir pour la selection
        //dd ($products);
        return $this->render('product/detail.html.twig', 
        [ 'productDetail' => $product, 
        //'productsPromos' => $productsPromos, 
     ]); 
    }

    #[Route('/products', name: 'product_list')]
    public function list(ProduitRepository $repo, PaginatorInterface $paginator, Request $request): Response 
    {
        //$queryBuilder = $repo->createQueryBuilder('p');
        $products = $repo->findAll(); 

        $pagination = $paginator->paginate(
            //$queryBuilder,
            $products,
            $request->query->getInt('page ', 1 ),
            10
        );
        dump($pagination);
        return $this->render('product/index.html.twig', [
        'pagination' => $pagination,
        ]);
    }
}

