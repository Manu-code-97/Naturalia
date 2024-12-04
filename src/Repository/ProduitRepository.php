<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produit>
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }


// fonction pour affichage des produits en promotions dans le HomeController 

    public function getProductsOnPromotion(): array
    {
    
        return $this->createQueryBuilder('p')
                ->where('p.prixPromo IS NOT NULL')
                // ->orderBy('p.id', 'ASC')
                // ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;
    }
    

    
    /* Fonction pour trouver des produit par rappor a sa sous catégorie dans le product controller */

public function findProductsBySousCategory($product) { 

    $dql = 
    '
    SELECT p 
    FROM App\Entity\Produit p 
    INNER JOIN App\Entity\SousCategorie s
    WHERE s.slug =:sousCategory
    '; 
    
    $query = $this->getEntityManager()->createQuery($dql); 
    $query->setParameter('sousCategory', $product); 
    
    return $query->getResult(); 
}


    
    /* Fonction pour trouver des produit par rappor a sa catégorie dans le product controller */

public function findProductsByCategory($productCategory) { 

    $dql = 
    '
    SELECT p , s.nom, c.nom
    FROM App\Entity\Produit p 
    INNER JOIN App\Entity\SousCategorie as s 
    INNER JOIN App\Entity\Categorie as c
    WHERE c.slug=:productCategory
    '; 
    
    $query = $this->getEntityManager()->createQuery($dql); 
    $query->setParameter('productCategory', $productCategory); 
    
    return $query->getResult(); 
}



    /* Trouver un produit par son label */

public function findProductByLabel($labelProduct){

    $dql=
    '
    SELECT p 
    FROM App\Entity\Produit p 
    INNER JOIN App\Entity\label as l 
    WHERE l.slug=:labelProduit
    ';

    $query = $this->getEntityManager()->createQuery($dql); 
    $query->setParameter('labelProduit', $labelProduit); 
    
    return $query->getResult(); 

}


    /* Trouver un produit en fonction de si il est local ou pas */

public function localProduct($localProduit){

    $dql=
    '
    SELECT p
    FROM App\Entity\Produit p
    WHERE p.local =:localProduit
    ';

    $query = $this->getEntityManager()->createQuery($dql);
    $query->setParameter('localProduit', $localProduit);

}


/* trier par prix et nom croissant  */
public function priceCroissant($nomProduit){

    $dql=
    '
    SELECT p
    FROM App\Entity\Produit p
    WHERE p.nom =:nomProduit
    ORDER BY nom, prix 
    
    ';

    $query = $this->getEntityManager()->createQuery($dql);
    $query->setParameter('nomProduit', $nomProduit);

}


/* trier par prix et nom décroissant  */
public function priceDesc($nomProduit){

    $dql=
    '
    SELECT p
    FROM App\Entity\Produit p
    WHERE p.nom =:nomProduit
    ORDER BY nom DESC, prix DESC
    
    ';

    $query = $this->getEntityManager()->createQuery($dql);
    $query->setParameter('nomProduit', $nomProduit);

}



/* SELECT * FROM produit as p INNER JOIN produit_label ON p.id=produit_id WHERE label_id={id};
{id}=x */

/* SELECT * FROM produit WHERE local=1; */

/* SELECT p.*, s.nom, c.nom FROM produit as p INNER JOIN sous_categorie as s ON p.sous_categorie_id=s.id INNER JOIN categorie as c ON s.categorie_id=c.id WHERE c.id={id}; */


/* !!! EN TRAVAUX !!!*/

/* public function localProduct($local)  
{
    SELECT * 
    FROM produit WHERE local=1; (modifié) */

/* Selection produit par label: */

    /* SELECT * 
    FROM produit as p 
    INNER JOIN produit_label ON p.id=produit_id 
    WHERE label_id={id};
    {id}=x
} */










    //    /**
    //     * @return Produit[] Returns an array of Produit objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Produit
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
