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
    #[Route('/categorie/{category}', name: 'catProduits', requirements: ['page' => '\d+'], defaults: ['page' => 1])]
    public function categoryProduit (Request $request, ProduitRepository $repo, CategorieRepository $repoCat, SousCategorieRepository $repoSCat, $category, int $page = 1 ): Response{
       
       
       $categoryEntity = $repoCat->showCategory($category);
       if (!$categoryEntity) {
           throw $this->createNotFoundException('Category not found');
       }

       $categoryId = $categoryEntity->getId();

    //    dd($category);

    $products = $repo->findProductsOfCategory($category);

    $limit = 20; // Nombre de produits par page
    $offset = ($page - 1) * $limit; // Calcul de l'offset
   /*  $category = $repoCat->showCategory($category); */


        // Compter le nombre total de produits pour calculer le nombre de pages
        $totalProducts = count($categoryEntity->getSousCategories()->map(fn($sousCategorie) => $sousCategorie->getProduit())->toArray());
        $totalPages = ceil($totalProducts / $limit);

        
        // Barre pagination dans les catégorie
        $products = $repo->findProductsByCategoryWithPagination($category, $offset, $limit);
        /* dd($products); */
        /* $products = $repo -> findProductsByCategory($category); */

        // Affiche les catégorie
        /* $category= $repoCat->showCategory($category); */

        // Trier par nom croissant et décroissant
       
        $sousCategoryId = 0; 
        $nomProduit = $request->query->get('nomProduit', ''); 
        $nameTrie = $repo->nameTrie($nomProduit, $categoryId, $sousCategoryId) ; 


        // Trier par prix croissant et décroissant
        
        $prixProduit = $request->query->get('prixProduit', '');  
        $priceTrie = $repo-> priceTrie($prixProduit, $categoryId, $sousCategoryId) ; 


        // Sort les produit en promos
        $productsPromos = $repo -> getProductsOnPromotion();

        

        // Liste des sous-catégorie dans une catégorie 
        $sousCategoryList= $repoSCat->getSousCategoriesFromCategory($categoryId);

        
        // $sousProduct = $repo->findProductsOfSousCategory($sousCategory);
        $sousCategoryId = 0; 

        
    
        // Récupérer les filtres depuis la requête
        $localForm = $request->query->get('local', null); 
        // dd($localForm);
        $labelIds = $request->query->all('label'); 

        // Appel de la méthode de filtrage par label et local
        $labelLocal = $repo->filterByLabelAndLocal($localForm, $labelIds, [$categoryId]);
        
        /* Récupére le nom des labels */
        $labels = $repo->getLabelsByCategory($categoryId); 


        //dd ($products);
        return $this->render('product/sousCatProducts.html.twig', 
        [ 'products' => $products,
        'category' => $categoryEntity,
        'labelsId' => $labelIds, 
        'labels' => $labels,
        'localForm' => $localForm, 
        'labelLocal' => $labelLocal,
        'priceTrie' => $priceTrie,
        'nameTrie'=> $nameTrie,
        'productsPromos' => $productsPromos,
        'sousCategories'=> $sousCategoryList,
        'sousCategoryId'=>$sousCategoryId,
        'sousCategory' => [],
        'sousproduct' => [], 
        'currentPage' => $page,
        'totalPages' => min($totalPages, 3), 
        'categoryId' => $categoryEntity->getId(),
        ]); 
    }




    /* Route pour afficher une sous catégorie d'une catégorie */
    #[Route('/categorie/{category}/{sousCategory}/', name: 'sousCatProduits', requirements: ['page' => '\d+'], defaults: ['page' => 1])]
    public function sousCategory (Request $request, ProduitRepository $repo, CategorieRepository $repoCat, SousCategorieRepository $repoSCat, $category, $sousCategory, int $page ): Response{
        
          // Charger la catégorie principale
          $categoryEntity = $repoCat->showCategory($category);
       if (!$categoryEntity) {
           throw $this->createNotFoundException('Category not found');
       }

       $categoryId = $categoryEntity->getId();

        
    
    // Charger les produits de la sous-catégorie
$products = $repo->findProductsOfSousCategory($sousCategory);


$limit = 20; // Nombre de produits par page
$offset = ($page - 1) * $limit; // Calcul de l'offset



// Compter le nombre total de produits pour calculer le nombre de pages
$totalProducts = $repo->count([]);
$totalPages = ceil($totalProducts / $limit);


// Barre pagination dans les sous-catégorie
$products = $repo -> findProductsBySousCategoryWithPagination( $sousCategory, $offset, $limit);



// Produits en promotion
$productsPromos = $repo->getProductsOnPromotion();


// Récupérer les filtres depuis la requête
$localForm = $request->query->get('local', null); 
$labelIds = $request->query->all('label'); 
$sousCategoryId = $repoSCat->getSousCategoriesId($sousCategory); 



// Liste des sous-catégorie dans les catégorie
$sousCategoryList= $repoSCat->getSousCategoriesFromCategory($categoryId);

// Appel de la méthode de filtrage par label et local
$labelLocal = $repo->filterByLabelAndLocal($localForm, $labelIds, $sousCategoryId, [$categoryId]);


// Trier par nom croissant et décroissant
$nomProduit = $request->query->get('nomProduit', ''); 
$nameTrie = $repo->nameTrie($nomProduit, $categoryId,$sousCategoryId) ; 


// Trier par prix croissant et décroissant
$prixProduit = $request->query->get('prixProduit', '');  
$priceTrie = $repo-> priceTrie($prixProduit, $categoryId, $sousCategoryId) ; 

// dd($prixProduit, $nomProduit );

/* Récupére le nom des labels */
$labels = $repo->getLabelsByCategory($categoryId); 

// Afficher la vue
return $this->render('product/sousCatProducts.html.twig', [
   // 'sousproduct' => $sousProduct, 
    'productsPromos' => $productsPromos, 
    'labelsId' => $labelIds,
    'labels' => $labels,         
    'labelLocal' => $labelLocal,
    'localForm'=> $localForm ,
    'category' => $category[0],
    'products' => $products,
    'sousCategories'=> $sousCategoryList,
    'sousCategoryId'=>$sousCategoryId,
    'currentPage' => $page,
    'totalPages' => min($totalPages, 3), // Limiter à 3 pages
    'nameTrie'=> $nameTrie,
    'priceTrie' => $priceTrie,
    'categoryId' => $categoryEntity->getId(),
    'category' => $categoryEntity,
]);
}
    




    // /* Cette route affiche un produit d'une sous catégorie */
    // #[Route('/produit/{product}', name: 'detailProduit')]
    // public function detailProduit (Request $request, ProduitRepository $repo , $product): Response{
    //     $productDetail = $repo->find($product);
        
        
    //     $productsSelection = $repo -> aleatProducts(20);
    //     //dd ($productsSelection);
    //     return $this->render('product/detail.html.twig', 
    //     [ 'productDetail' => $productDetail, 
        
    //     'productsSelection' => $productsSelection, 
    // ]); 
    // }

    #[Route('/produit/{slug}', name: 'detailProduit')]
    public function detailProduit(Request $request, ProduitRepository $repo, string $slug): Response
    {
    $productDetail = $repo->findOneBy(['slug' => $slug]); // Find product by slug
    if (!$productDetail) {
        throw $this->createNotFoundException('Product not found.');
    }
    
    $productsSelection = $repo->aleatProducts(20);

    return $this->render('product/detail.html.twig', [
        'productDetail' => $productDetail,
        'productsSelection' => $productsSelection,
    ]);
}





    /* Function qui sert à afficher le nom des sous catégorie */
    function getSousCategoryName($sousCategory) : String {
        
        $sousCategoryName = $sousCategory[0]->getNom();
        //dd($sousCategoryName);
        return $sousCategoryName;
    }


    /* #[Route('/products/{page}', name: 'product_list', requirements: ['page' => '\d+'], defaults: ['page' => 1])]
    public function list(ProduitRepository $productRepository, int $page): Response
    {
        $limit = 20; // Nombre de produits par page
        $offset = ($page - 1) * $limit; // Calcul de l'offset

        // Récupérer les produits avec pagination
        $products = $productRepository->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        // Compter le nombre total de produits pour calculer le nombre de pages
        $totalProducts = $productRepository->count([]);
        $totalPages = ceil($totalProducts / $limit);

        return $this->render('product/list.html.twig', [
            'products' => $products,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);
    } *//* Function qui sert à afficher le nom des catégorie */

    
    // public function showMenu(CategorieRepository $categoryRepository): Response 
    // { 
    //     $categories = $categoryRepository->findAll(); 
    //     $formattedCategories = CategoryHelper::formatCategories($categories); 
        
    //     return $this->render('partials/menu.html.twig', [ 
    //         'categories' => $formattedCategories, 
    //     ]);
    // }


    #[Route('/search', name: 'search')]
    public function searchBox(Request $request, ProduitRepository $productRepository): Response
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        $products = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $query = $form->get('query')->getData();
            $products = $productRepository->findByQuery($query);
        }

        return $this->render('_fragment/searchBox.html.twig', [
            'form' => $form->createView(),
            'products' => $products,
        ]);
    }
}
