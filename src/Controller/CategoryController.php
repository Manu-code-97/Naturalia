<?php

namespace App\Controller;

use App\Entity\Categorie;
use app\Entity\Produit;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index($category): Response
    {
        
        
        return $this->render('category/index.html.twig', [
            
            'category'=> $category,
        ]);
    }




    /* Route pour un produit de puis categorie  */


    #[Route('/category/{category}/product/{product}', name: 'app_category_{category}')]
    public function category(CategorieRepository $repo, string $slug): Response
    {

        /* en attente de rajoue une function*/
       /*  $product= $repo->showProduct(); */

        $category = $repo->findOneBy(['slug' => $slug]);
        
        
        ;
        return $this->render('product/product.html.twig', [
            'product' => $product,
        ]);
    } 
    


}

    


/* NE PAS FAIRE ATTENTION */

/* dd ($product);  //tester l'affichage  */ 

        /*  $query = $repository->createQuery(
            'SELECT p.name p.price p., COUNT(p)
            FROM App\Entity\Produit p
            -- INNER JOIN App\Entity\User
            -- WHERE q.creationDate < :today AND q.closingDate > :today
            -- WHERE 1
            GROUP BY 
        ');

        $product = $repository->findOneBy(['slug' => $slug]); */
        // chercher les produit dans la BD
        // $produits = la requette

        /*  $query = $repo->createQuery(
            'SELECT p.name p.price , COUNT(p)
            FROM App\Entity\Categorie p
            -- INNER JOIN App\Entity\User
            -- WHERE q.creationDate < :today AND q.closingDate > :today
            -- WHERE 1
            GROUP BY 
        '); */