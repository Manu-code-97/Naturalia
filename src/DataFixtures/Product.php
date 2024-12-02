<?php

namespace App\DataFixtures;

use App\Config\Statut;
use Faker\Factory as FakerFactory;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Entity\CodeReduction;
use App\Entity\Commande;
use App\Entity\Fournisseur;
use App\Entity\Label;
use App\Entity\Magasin;
use App\Entity\Newsletter;
use App\Entity\Recette;
use App\Entity\SousCategorie;
use App\Entity\Utilisateur;
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

    private array $adresse = [
        'Rue',
        'Avenue',
        'Boulevard'
    ];

    private array $labels = [];

    private array $produits = [];

    private array $utilisateurs = [];

    private array $magasins = [];

    private array $commandes = [];

    private array $codeReductions = [];

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
            $fournisseur->setAdresse($fakerFR->departmentNumber().' '.$this->adresse[rand(0,2)].' '.$fakerFR->region());
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
            array_push($this->labels, $label);
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
                // LIAISON LABELS
                $produit->addLabel($this->labels[rand(0, 4)]);
                
                $manager->persist($produit);
                array_push($this->produits, $produit);
            }
        }

        // RECETTES
        for ($i=0; $i < 15; $i++) { 
            $recette = new Recette();
            $recette->setImage('https://picsum.photos/id/'.$faker->numberBetween(0, 300).'/200/300');
            $recette->setNom($faker->sentence(3));
            $recette->setDescription($faker->paragraph());
            $recette->setSlug($slugger->slug($recette->getNom())->lower());
            // LIAISON INGREDIENTS
            $recette->addProduit($this->produits[rand(0,count($this->produits)-1)]);
            $recette->addProduit($this->produits[rand(0,count($this->produits)-1)]);
            $recette->addProduit($this->produits[rand(0,count($this->produits)-1)]);
            $recette->addProduit($this->produits[rand(0,count($this->produits)-1)]);
            $recette->addProduit($this->produits[rand(0,count($this->produits)-1)]);

            $manager->persist($recette);
        }

        // UTILISATEURS
        for ($i=0; $i < 150; $i++) { 
            $utilisateur = new Utilisateur();
            $utilisateur->setNom($fakerBE->lastName());
            $utilisateur->setPrenom($faker->firstNameMale());
            $utilisateur->setTelephone($fakerFR->serviceNumber());
            $utilisateur->setEmail($fakerFR->safeEmail());
            $utilisateur->setAdresse($fakerFR->departmentNumber().' '.$this->adresse[rand(0,2)].' '.$fakerFR->region());
            $utilisateur->setCodePostal($faker->randomNumber(5, true));
            $utilisateur->setVille($fakerFR->departmentName());
            // LIAISON FAVORIS
            if (rand(0,2)!==0) {
                $utilisateur->addFavori($this->produits[rand(0,count($this->produits)-1)]);
                $utilisateur->addFavori($this->produits[rand(0,count($this->produits)-1)]);
                $utilisateur->addFavori($this->produits[rand(0,count($this->produits)-1)]);
            } else {
                null;
            }

            $manager->persist($utilisateur);
            array_push($this->utilisateurs, $utilisateur);
        }

        // MAGASINS
        for ($i=0; $i < 80; $i++) { 
            $magasin = new Magasin();
            $magasin->setImage('https://picsum.photos/id/'.$faker->numberBetween(0, 300).'/200');
            $magasin->setNom('Naturalia '.$fakerFR->departmentName().' '.$i);
            $magasin->setTelephone($fakerFR->serviceNumber());
            $magasin->setEmail($fakerFR->safeEmail());
            $magasin->setAdresse($fakerFR->departmentNumber().' '.$this->adresse[rand(0,2)].' '.$fakerFR->region());
            $magasin->setCodePostal($faker->randomNumber(5, true));
            $magasin->setVille($fakerFR->departmentName());
            $magasin->setHoraire('
                <li>lundi:    09:00 AM - 20:30 PM</li>
                <li>mardi:    09:00 AM - 20:30 PM</li>
                <li>mercredi: 09:00 AM - 20:30 PM</li>
                <li>jeudi:    09:00 AM - 20:30 PM</li>
                <li>vendredi: 09:00 AM - 20:30 PM</li>
                <li>samedi:   09:00 AM - 20:30 PM</li>
                <li>dimanche: fermé </li>
            ');

            $manager->persist($magasin);
            array_push($this->magasins, $magasin);
        }

        // CODE REDUCTION
        for ($i=0; $i < 30; $i++) { 
            $codeReduction = new CodeReduction();
            $codeReduction->setCode($faker->swiftBicNumber());
            $codeReduction->setDateDebut($faker->dateTimeBetween('-2 weeks', '0 days'));
            $codeReduction->setDateExpiration($faker->dateTimeBetween('0 days', '+3 months'));
            $codeReduction->setPourcentage($faker->numberBetween(10, 50));

            $manager->persist($codeReduction);
            array_push($this->codeReductions, $codeReduction);
        }

        // COMMANDES
        for ($i=0; $i < 200; $i++) { 
            $commande = new Commande();
            $commande->setNumero($faker->isbn10());
            $commande->setDateCreation($faker->dateTimeBetween('-2 weeks', '0 days'));
            $commande-> setDateExpedition($faker->dateTimeBetween('0 days', '+1 month'));
            $commande->setStatut($faker->randomElement(Statut::class));
            $commande->setRemplacementProduit($faker->boolean());
            $commande->setCommentaire((rand(0, 1)==0)?$faker->paragraph():null);
            $commande->setUtilisateur($this->utilisateurs[rand(0, count($this->utilisateurs)-1)]);
            $commande->setMagasin((rand(0,3)!==0)?$this->magasins[rand(0, count($this->magasins)-1)]:null);
            (rand(0,7)==0)?$commande->setCodeReduction($this->codeReductions[rand(0, count($this->codeReductions)-1)]):null;

            // PRODUITS DANS LES COMMANDES
            $commande->addProduit($this->produits[rand(0, count($this->produits)-1)]);
            $commande->addProduit($this->produits[rand(0, count($this->produits)-1)]);
            $commande->addProduit($this->produits[rand(0, count($this->produits)-1)]);
            $commande->addProduit($this->produits[rand(0, count($this->produits)-1)]);
            $commande->addProduit($this->produits[rand(0, count($this->produits)-1)]);
            $commande->addProduit($this->produits[rand(0, count($this->produits)-1)]);
            
            $manager->persist($commande);
            array_push($this->commandes, $commande);
        }

        // NEWSLETTER
        for ($i=0; $i < 100; $i++) { 
            $newsletter = new Newsletter();
            $newsletter->setEmail($fakerFR->safeEmail());

            $manager->persist($newsletter);
        }

        $manager->flush();
    }
}
