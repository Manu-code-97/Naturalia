<?php

namespace App\DataFixtures;

use Faker\Factory as FakerFactory;

use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Product extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create();
        $produit = new Produit();

        for ($i=0; $i < 100; $i++) { 
            $produit = new Produit();
            $produit->setImage('https://picsum.photos/200');
            $produit->setNom($faker->sentence(3));
            $produit->setDescription($faker->paragraph());
            $produit->setPrix($faker->randomNumber(3, false));
            $produit->setQuantiteStock($faker->randomNumber(4, false));
            $produit->setLocal($faker->numberBetween(0, 1));
            $produit->setOrigine($faker->paragraph());
            $produit->setMarque($faker->paragraph());
            $produit->setIngredient($faker->paragraph());
            $produit->setPoids($faker->randomFloat(2, 0, 20));
            $produit->setPrixPromo($faker->randomFloat(3, false));
            $produit->setSlug($faker->randomFloat(3, false));

            $manager->persist($produit);
        }

        $manager->flush();
    }
}
