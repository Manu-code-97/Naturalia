<?php

namespace App\DataFixtures;

use Faker\Factory as FakerFactory;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Entity\Fournisseur;
use App\Entity\Label;
use App\Entity\SousCategorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Component\String\Slugger\AsciiSlugger;

class Product extends Fixture
{

    private array $categories = [];
    private array $categoriesNoms = [
        'Fruits et Légumes',
        'Épicerie Salée',
        'Épicerie Sucrée',
        'Produits Frais',
        'Boissons'
    ];
    private array $sousCategories = [];
    private int $j = 0;
    private array $sousCategoriesNoms = [
        'Fruits de saison',
        'Légumes racines',
        'Aromates et herbes fraîches',
        'Céréales et légumineuses',
        'Conserves bio',
        'Produits secs',
        'Miels et confitures',
        'Biscuits et snacks',
        'Chocolats bio',
        'Produits laitiers',
        'Produits végétaux frais',
        'Charcuterie bio',
        'Jus de fruits et légumes',
        'Boissons végétales',
        'Thés et infusions'
    ];
    private array $fournisseurs = [];

    public function load(ObjectManager $manager): void
    {

        $slugger = new AsciiSlugger();

        $faker = FakerFactory::create();
        $fakerFR = FakerFactory::create('fr_FR');
        $fakerBE = FakerFactory::create('fr_BE');

        // CATEGORIES
        for ($i=0; $i < 5; $i++){
            $categorie = new Categorie();
            $categorie->setNom($this->categoriesNoms[$i]);
            $categorie->setSlug($slugger->slug($categorie->getNom())->lower());

            $manager->persist($categorie);
            array_push($this->categories, $categorie);
        }

        // SOUS-CATEGORIES
        foreach ($this->categories as $categorie){
            for ($i=0; $i < 3; $i++) { 
                $sousCategorie = new SousCategorie();
                $sousCategorie->setCategorie($categorie);
                $sousCategorie->setNom($this->sousCategoriesNoms[$this->j]);
                $sousCategorie->setSlug($slugger->slug($sousCategorie->getNom())->lower());

                $manager->persist($sousCategorie);
                array_push($this->sousCategories, $sousCategorie);
                $this->j++;
            }
        }

        // FOURNISSEURS
        for ($i=0; $i < 20; $i++) { 
            $fournisseur = new Fournisseur();
            $fournisseur->setNom($fakerBE->lastName());
            $fournisseur->setPrenom($faker->firstNameMale());
            $fournisseur->setAdresse($fakerFR->departmentNumber().' '.$fakerFR->region());
            $fournisseur->setCodePostal($faker->randomNumber(5, true));
            $fournisseur->setVille($fakerFR->departmentName());
            $fournisseur->setTelephone($fakerFR->serviceNumber());
            $fournisseur->setEmail($fakerFR->safeEmail());
            $fournisseur->setSlug($slugger->slug($fournisseur->getNom().'-'.$fournisseur->getPrenom())->lower());

            $manager->persist($fournisseur);
            array_push($this->fournisseurs, $fournisseur);
        }

        //LABELS
        for ($i=0; $i < 5; $i++) { 
            $label = new Label();
            $label->setNom($faker->word());
            $label->setScore($faker->numberBetween(10, 50));
            $label->setImage('https://picsum.photos/id/'.$faker->numberBetween(0, 300).'/50');

            $manager->persist($label);
        }

        // PRODUITS
        foreach ($this->sousCategories as $sousCategorie){   
            for ($i=0; $i < 30; $i++) { 
                $produit = new Produit();
                $produit->setImage('https://picsum.photos/id/'.$faker->numberBetween(0, 300).'/200');
                $produit->setNom($faker->sentence(3));
                $produit->setDescription($faker->sentence(10));
                $produit->setPrix($faker->randomNumber(3, false));
                $produit->setQuantiteStock($faker->randomNumber(4, false));
                $produit->setLocal($faker->numberBetween(0, 1));
                $produit->setOrigine($faker->paragraph());
                $produit->setMarque($faker->paragraph());
                $produit->setIngredient((rand(0,5)!==0)?$faker->paragraph():null);
                $produit->setPoids($faker->randomFloat(2, 0, 20));
                $produit->setPrixPromo((rand(0,6)==0)?$faker->randomFloat(2, $produit->getPrix()*0.5, $produit->getPrix()*0.9):null);
                $produit->setSlug($slugger->slug($produit->getNom())->lower());
                $produit->setSousCategorie($sousCategorie);
                $produit->setFournisseur($this->fournisseurs[rand(0,19)]);
                
                $manager->persist($produit);
            }
        }

        $manager->flush();
    }
}
