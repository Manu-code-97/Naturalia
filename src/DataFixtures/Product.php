<?php

namespace App\DataFixtures;

use Faker\Factory as FakerFactory;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Entity\SousCategorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\AsciiSlugger;

class Product extends Fixture
{

    private array $categories = [];
    private array $sousCategories = [];

    public function load(ObjectManager $manager): void
    {

        $slugger = new AsciiSlugger();

        $faker = FakerFactory::create();

        for ($i=1; $i <= 5; $i++){
            $categorie = new Categorie();
            $categorie->setNom('categorie'.$i);
            $categorie->setSlug($slugger->slug($categorie->getNom())->lower());

            $manager->persist($categorie);
            array_push($this->categories, $categorie);
        }

        foreach ($this->categories as $categorie){
            for ($i=0; $i < 3; $i++) { 
                $sousCategorie = new SousCategorie();
                $sousCategorie->setCategorie($categorie);
                $sousCategorie->setNom($faker->sentence(2));
                $sousCategorie->setSlug($slugger->slug($sousCategorie->getNom())->lower());

                $manager->persist($sousCategorie);
                array_push($this->sousCategories, $sousCategorie);
            }
        }

        foreach ($this->sousCategories as $sousCategorie){   
            for ($i=0; $i < 50; $i++) { 
                $produit = new Produit();
                $produit->setImage('https://picsum.photos/200');
                $produit->setNom($faker->sentence(3));
                $produit->setDescription($faker->sentence(10));
                $produit->setPrix($faker->randomNumber(3, false));
                $produit->setQuantiteStock($faker->randomNumber(4, false));
                $produit->setLocal($faker->numberBetween(0, 1));
                $produit->setOrigine($faker->paragraph());
                $produit->setMarque($faker->paragraph());
                $produit->setIngredient($faker->paragraph());
                $produit->setPoids($faker->randomFloat(2, 0, 20));
                $produit->setPrixPromo((rand(0,6)==0)?$faker->randomFloat(2, 1, 100):null);
                $produit->setSlug($slugger->slug($produit->getNom())->lower());
                $produit->setSousCategorie($sousCategorie);
                
                $manager->persist($produit);
            }
        }

        $manager->flush();
    }
}
