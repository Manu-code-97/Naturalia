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
    // #[Route('/categorie', name: 'app_product')] 
    // public function showProduct(ProduitRepository $repo): Response { 
        
    //     $products = $repo->findAll(); 
    //     return $this->render('product/index.html.twig', 
    //     [ 'products' => $products, ]); 
    // } 


    /* Route pour afficher une sous catégorie d'une catégorie */
    #[Route('/{category}/{sousCategory}/', name: 'sousCatProduits')]
    public function sousCategory (ProduitRepository $repo, CategorieRepository $repoCat, SousCategorieRepository $repoSCat, $category, $sousCategory): Response{
        $products = $repo -> findProductsBySousCategory($sousCategory);
        $productsPromos = $repo -> getProductsOnPromotion();
        
        $category= $repoCat->showCategory($category);
        $sousCategoryList= $repoSCat->getSousCategoriesFromCategory($category[0]->getId());
        //dd ($products);
        return $this->render('product/index.html.twig', 
        [ 'products' => $products, 
        'productsPromos' => $productsPromos,  
        'sousCategories'=> $sousCategoryList,
        'category'=> $category[0],
        'sousCategoryId' => $sousCategory, // a changer quand on passera au slug

    ]); 
    }


    /* Cette route affiche une catégorie spécifique avec son slug */
    #[Route('/categorie/{category}', name: 'catProduits', priority:1)]
    public function categoryProduit (ProduitRepository $repo, CategorieRepository $repoCat, SousCategorieRepository $repoSCat, $category): Response{
        $products = $repo -> findProductsByCategory($category);
        $productsPromos = $repo -> getProductsOnPromotion();
        $category= $repoCat->showCategory($category);
        $sousCategoryList= $repoSCat->getSousCategoriesFromCategory($category[0]->getId());

        // dd ($products);
        return $this->render('product/index.html.twig', 
        [ 'products' => $products, 
        'productsPromos' => $productsPromos,
        'category'=> $category[0],
        'sousCategories'=> $sousCategoryList,
    ]); 
    }

    
    /* Cette route affiche un produit d'une sous catégorie */
    #[Route('/{category}/{sousCategory}/{product}', name: 'detailProduit')]
    public function detailProduit (ProduitRepository $repo , $product): Response{
        $product = $repo->find($product);

        /* a voir pour label et local (pour linstant elles reste la) */
        $label = $repo->findProductByLabel($labelProduct);
        $local = $repo->localProduct($localProduit);
        
        
        // $productsSelection = $repo -> getProductsOnPromotion(); // a voir pour la selection
        //dd ($products);
        return $this->render('product/detail.html.twig', 
        [ 'productDetail' => $product, 
        'labelProduit' => $label,
        'local' => $local,
        //'productsPromos' => $productsPromos, 
    ]); 
    }

    /* Affiche la liste des produit */
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



    /* Function qui sert à afficher le nom des sous catégorie */
    function getSousCategoryName($sousCategory) : String {
        
        $sousCategoryName = $sousCategory[0]->getNom();
        //dd($sousCategoryName);
        return $sousCategoryName;
    }
}

