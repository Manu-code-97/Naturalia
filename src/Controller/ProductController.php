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
    public function categoryProduit (ProduitRepository $repo, CategorieRepository $repoCat, SousCategorieRepository $repoSCat, $category): Response{
        $products = $repo -> findProductsByCategory($category);
        $productsPromos = $repo -> getProductsOnPromotion();
        $category= $repoCat->showCategory($category);
        $sousCategoryList= $repoSCat->getSousCategoriesFromCategory($category[0]->getId());

        
/* dd($categoriesMenu); */
        // dd ($products);
        return $this->render('product/sousCatProducts.html.twig', 
        [ 
        'products'=>$products,
        'productsPromos' => $productsPromos,
        'category'=> $category[0],
        'sousCategories'=> $sousCategoryList,
        'sousCategoryId' => 0,
        ]); 
    }



    /* Route pour afficher une sous catégorie d'une catégorie */
    #[Route('/categorie/{category}/{sousCategory}/', name: 'sousCatProduits')]
    public function sousCategory (Request $request, ProduitRepository $repo, CategorieRepository $repoCat, $category, $sousCategory): Response{
        $sousProduct = $repo->findProductsOfSousCategory($sousCategory); 
        $productsPromos = $repo -> getProductsOnPromotion();
        
        $category= $repoCat->showCategory($category);
        /* $sousCategoryList= $repoSCat->getSousCategoriesFromCategory($category[0]->getId()); */



        /* Affichage trie local ou afficher tout les produit */
        $localForm = $request->query->get('localForm', null); 
        $produits = $repo->localForm($localForm);
        


        /* Affichage filtre de produit par label */
        $labelIds = $request->query->all('labelForm'); // Récupère un tableau, même si une seule valeur
        $labelIds = $repo->labelForm($labelIds);

        
        //dd ($products);
        return $this->render('product/sousCatProducts.html.twig', 
        [ 'sousproduct' => $sousProduct, 
        'productsPromos' => $productsPromos, 
        'label' => $labelIds,
        'produits' => $produits,
        /* 'sousCategories'=> $sousCategoryList, */
        'category'=> $category[0],
        'sousCategory' => $sousCategory, // a changer quand on passera au slug

        ]); 
    }


    /* Cette route affiche un produit d'une sous catégorie */
    #[Route('/produit/{product}', name: 'detailProduit')]
    public function detailProduit (Request $request , ProduitRepository $repo , $product): Response{
        $productDetail = $repo->find($product);

        /* Affichage filtre de produit par label et local */
        $localForm = $request->query->get('local', null); 
        $labelIds = $request->query->all('label');
        $categoryIds = $request->query->get('Categorie');
        $sousCategoryId = $request->query->get('sousCategorie');

        // Appel de la méthode avec les bons paramètres
        $labelLocal = $repo->filterByLabelAndLocal($localForm, $labelIds, $sousCategoryId , $categoryIds );

        $productsSelection = $repo -> aleatProducts(20);
        //dd ($productsSelection);
        return $this->render('product/detail.html.twig', 
        [ 'productDetail' => $productDetail, 
        'labelLocal' => $labelLocal , 
        'productsSelection' => $productsSelection,
    ]); 
    }

    /* Affiche la liste des produit un (test) */
   // #[Route('/{sousCategory}', name: 'product_list')]
    //public function list($sousCategory, ProduitRepository $repo , PaginatorInterface $paginator, Request $request): Response 
    //{
        //$queryBuilder = $repo->createQueryBuilder('p');
        

        //$pagination = $paginator->paginate(
            //$queryBuilder,
            //$products,
            //$request->query->getInt('page ', 1 ),
            //10
        //);
        /* dump($pagination);
        return $this->render('product/index.html.twig', [
        'pagination' => $pagination,
        'sousProduct' => $sousProduct,
        ]);
    } */



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
