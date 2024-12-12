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
use App\Helper\CategoryHelper;
use App\Form\SearchType;

class ProductController extends AbstractController 
{ 
    // #[Route('/categorie', name: 'app_product')] 
    // public function showProduct(ProduitRepository $repo): Response { 
        
    //     $products = $repo->findAll(); 
    //     return $this->render('product/index.html.twig', 
    //     [ 'products' => $products, ]); 
    // } 


    /* Cette route affiche une catégorie ainsi que ces produits */
    #[Route('/categorie/{category}', name: 'catProduits', priority:1)]
    public function categoryProduit (Request $request, ProduitRepository $repo, CategorieRepository $repoCat, SousCategorieRepository $repoSCat, $category ): Response{

        $products = $repo -> findProductsByCategory($category);
        $productsPromos = $repo -> getProductsOnPromotion();
        $category= $repoCat->showCategory($category);
        $sousCategoryList= $repoSCat->getSousCategoriesFromCategory($category[0]->getId());

        // $sousProduct = $repo->findProductsOfSousCategory($sousCategory);
        // $sousCategoryId = $sousCategory; 

    
    
        // Récupérer les filtres depuis la requête
        $localForm = $request->query->get('local', null); 
        $labelIds = $request->query->all('label'); 
    
        $categoryId = $category[0]->getId(); 
    
        // Appel de la méthode de filtrage par label et local
        $labelLocal = $repo->filterByLabelAndLocal($localForm, $labelIds, [$categoryId]);
        

        //dd ($products);
        return $this->render('product/sousCatProducts.html.twig', 
        [ 'products' => $products, 
        'labelLocal' => $labelLocal,
        'productsPromos' => $productsPromos,
        'category'=> $category[0],
        'sousCategories'=> $sousCategoryList,
        'sousCategory' => [],
        'sousproduct' => [], 
        ]); 
    }




    /* Route pour afficher une sous catégorie d'une catégorie */
    #[Route('/categorie/{category}/{sousCategory}/', name: 'sousCatProduits')]
    public function sousCategory (Request $request, ProduitRepository $repo, CategorieRepository $repoCat, $category, $sousCategory): Response{
        
         // Charger la catégorie principale
    $category = $repoCat->showCategory($category);
        
    
        // Charger les produits de la sous-catégorie
    $sousProduct = $repo->findProductsOfSousCategory($sousCategory);


    // Produits en promotion
    $productsPromos = $repo->getProductsOnPromotion();


    // Récupérer les filtres depuis la requête
    $localForm = $request->query->get('local', null); 
    $labelIds = $request->query->all('label'); 

    $sousCategoryId = $sousCategory; 
    $categoryId = $category[0]->getId(); 

    // Appel de la méthode de filtrage par label et local
    $labelLocal = $repo->filterByLabelAndLocal($localForm, $labelIds, $sousCategoryId, [$categoryId]);

    // Afficher la vue
    return $this->render('product/sousCatProducts.html.twig', [
        'sousproduct' => $sousProduct, 
        'productsPromos' => $productsPromos, 
        'labelLocal' => $labelLocal,
        'category' => $category[0],
        'sousCategory' => $sousCategory,
    ]);
    }
    




    /* Cette route affiche un produit d'une sous catégorie */
    #[Route('/produit/{product}', name: 'detailProduit')]
    public function detailProduit ( ProduitRepository $repo , $product): Response{
        $productDetail = $repo->find($product);


        
        $productsSelection = $repo -> aleatProducts(20);
        //dd ($productsSelection);
        return $this->render('product/detail.html.twig', 
        [ 'productDetail' => $productDetail, 
        
        'productsSelection' => $productsSelection, 
    ]); 
    }


     



    /* Function qui sert à afficher le nom des sous catégorie */
    function getSousCategoryName($sousCategory) : String {
        
        $sousCategoryName = $sousCategory[0]->getNom();
        //dd($sousCategoryName);
        return $sousCategoryName;
    }




    
    // public function showMenu(CategorieRepository $categoryRepository): Response 
    // { 
    //     $categories = $categoryRepository->findAll(); 
    //     $formattedCategories = CategoryHelper::formatCategories($categories); 
        
    //     return $this->render('partials/menu.html.twig', [ 
    //         'categories' => $formattedCategories, 
    //     ]);
    // }


    public function search(Request $request, ProduitRepository $productRepository): Response
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        $products = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $query = $form->get('query')->getData();
            $products = $productRepository->findByQuery($query);
        }

        return $this->render('partials/header.html.twig', [
            'form' => $form->createView(),
            'products' => $products,
        ]);
    }
}
