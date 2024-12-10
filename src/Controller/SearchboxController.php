<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SearchboxController extends AbstractController
{
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
