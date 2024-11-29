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
    
    /* route qui affiche toute les categories */

    #[Route('/category', name: 'app_category')]
    public function cate(CategorieRepository $repo): Response
    {
        
        $category = $repo->findAll();
        
        return $this->render('category/index.html.twig', [
            
            'category'=> $category,
        ]);
    }

    /*Route pour afficher une categorie en particularité  */

    #[Route('/category/{category}', name: 'app_category_category')]
    public function index(CategorieRepository $repo, $sousCategory): Response
    {
        
        $sousCategory= $repo->showSousCategory($sousCategory);
        
        return $this->render('category/index.html.twig', [
            
            'sousCategory'=> $sousCategory,
        ]);
    }


    
    


}

