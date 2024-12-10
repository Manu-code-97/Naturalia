<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    public function menu(CategorieRepository $categorieRepository): Response
    {
        $categoriesMenu = $categorieRepository->findAll();

        return $this->render('_fragment/menu.html.twig', [
            'categoriesMenu' => $categoriesMenu,
        ]);
    }
}
