<?php
// src/Helper/CategoryHelper.php

namespace App\Helper;

use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response; 

class CategoryHelper
{
    public static function generateSlug(string $text): string
    {
        // Remplace les espaces et autres caractères par des tirets, convertit en minuscule, etc.
        $text = preg_replace('/[^A-Za-z0-9-]+/', '-', $text);
        return strtolower(trim($text, '-'));
    }

    // public static function formatCategories(array $categories): array
    // {
    //     //dd($categories, $categories[0]->getSousCategories());
    //     // Logique pour formater les catégories si nécessaire
    //     foreach ($categories as &$category) {
    //         $categorieMere['slug'] = self::generateSlug($category->getNom());
    //         if (isset($categoryFille['children'])) {
    //             $categoryFille['children'] = self::formatCategories($category['children']);
    //         }
    //     }
    //     return $categories;
    // }
    public static function showMenu(CategorieRepository $categoryRepository): array 
    { 
        // $categories = $categoryRepository->findAll();
        $categories = $categoryRepository->categoryAll();
        
        
        //$formattedCategories = self::formatCategories($categories); 
        return $categories;        
        // return self::render('partials/menu.html.twig', [ 
        //     'categories' => $formattedCategories, 
        // ]);
    }
}
