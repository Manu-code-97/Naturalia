<?php

namespace App\Controller;

use App\Entity\Categorie;
use app\Entity\Produit;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use App\Repository\SousCategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    
    /* route qui affiche toute les categories */

    // #[Route('/category', name: 'app_category')]
    // public function index(CategorieRepository $repo): Response
    // {
        
    //     $category = $repo->findAll();
        
        
    //     return $this->render('category/index.html.twig', [
    //         'underCategory' => $this->getSousCategoryName($category),
    //         'categories'=> $category,
    //     ]);
    // }

    // /*Route pour afficher une categorie avec ses sous catégorie  */

    // #[Route('/category/{category}/{sousCategory}', name: 'app_category_category')]
    // public function sousCat(CategorieRepository $repoCat, SousCategorieRepository $repo, $category, $sousCategory): Response
    // {
        
    //     $category= $repoCat->showCategory($category);
    //     $sousCategoryList= $repo->getSousCategoriesFromCategory($category[0]->getId());
    //     //dd($sousCategory);
        
    //     return $this->render('category/sousCatProducts.html.twig', [
    //         //'underCategory' => $this->getSousCategoryName($sousCategory),
    //         'sousCategories'=> $sousCategoryList,
    //         'category'=> $category[0],
    //         'sousCategoryId' => $sousCategory, // a changer quand on passera au slug
    //     ]);
    // }

    // #[Route('/category/{category}/{sousCategory}/{product}', name: 'app_sous_category_products')]
    // public function sousCategory (ProduitRepository $repo , $sousCategory): Response{
    //     $products = $repo -> findProductsBySousCategory($sousCategory);
    //     $productsPromos = $repo -> getProductsOnPromotion();
    //     //dd ($products);
    //     return $this->render('product/index.html.twig', 
    //     [ 'products' => $products, 
    //     'productsPromos' => $productsPromos,  ]); 
    // }


    // function getSousCategoryName($sousCategory) : String {
        
    //     $sousCategoryName = $sousCategory[0]->getNom();
    //     //dd($sousCategoryName);
    //     return $sousCategoryName;
    // }
    


}

