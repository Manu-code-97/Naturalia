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


    /* Cette route affiche une catégorie ainsi que ces produits */
    #[Route('/categorie/{category}', name: 'catProduits', priority:1)]
    public function categoryProduit (ProduitRepository $repo, CategorieRepository $repoCat, SousCategorieRepository $repoSCat, $category): Response{
        $products = $repo -> findProductsByCategory($category);
        $productsPromos = $repo -> getProductsOnPromotion();
        $category= $repoCat->showCategory($category);
        $sousCategoryList= $repoSCat->getSousCategoriesFromCategory($category[0]->getId());

        //dd ($products);
        return $this->render('product/sousCatProducts.html.twig', 
        [ 'products' => $products, 
        'aleat' => $aleat,
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
    public function detailProduit (ProduitRepository $repo , $product): Response{
        $productDetail = $repo->find($product);

        /* a voir pour label et local (pour linstant elles reste la) */
        $label = $repo->findProductByLabel(10);
        $local = $repo->localProduct(1);
        
        
        $productsSelection = $repo -> aleatProducts(20);
        //dd ($productsSelection);
        return $this->render('product/detail.html.twig', 
        [ 'productDetail' => $productDetail, 
        'labelProduit' => $label,
        'local' => $local,
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


}

