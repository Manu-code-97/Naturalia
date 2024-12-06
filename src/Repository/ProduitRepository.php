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
    SELECT p , s.nom as nomSousCat
    FROM App\Entity\Produit p 
    INNER JOIN App\Entity\SousCategorie s
    WHERE s.slug =:sousCategory
    '; 
    
    $query = $this->getEntityManager()->createQuery($dql); 
    $query->setParameter('sousCategory', $product); 
    
    return $query->getResult(); 
}


/* Afficher tout les produit d'une sous-catégorie */

public function findProductsOfSousCategory($sousCategory) { 


    $dql = 
    ' 
    SELECT sc , p 
    FROM App\Entity\SousCategorie sc
    INNER JOIN sc.produit p
    WHERE sc.slug =:sousCategory
    ';
    $query = $this->getEntityManager()->createQuery($dql); 
    $query->setParameter('sousCategory', $sousCategory); 
    
    /* dd($query->getResult()); */
    return $query->getResult(); 
}


    
    /* Fonction pour trouver des produit par rappor a sa catégorie dans le product controller */

public function findProductsByCategory($productCategory) { 

    $dql = 
    '
    SELECT c,  p , s 
    FROM  App\Entity\Categorie c
    INNER JOIN c.sousCategories s 
    INNER JOIN s.produit p
    WHERE c.slug=:productCategory
    '; 
    
    $query = $this->getEntityManager()->createQuery($dql); 
    $query->setParameter('productCategory', $productCategory); 
    
    
    return $query->getResult(); 
}




    /* Trouver un produit par son label(ne filtre pas!) */

public function findProductByLabel($labelProduit){

    $dql=
    '
    SELECT p 
    FROM App\Entity\Produit p 
    INNER JOIN p.label l 
    WHERE l.id=:labelProduit
    ';

    $query = $this->getEntityManager()->createQuery($dql); 

    $query->setParameter('labelProduit', $labelProduit); 
    
    return $query->getResult(); 
    
}



/* Function pour filtrer par label */
public function labelForm(array $labelIds){

    $qb = $this->createQueryBuilder('p') // Requête sur l'entité Produit.
        ->join('p.label', 'l')          // Jointure avec la table des labels.
        ->where('l.id IN (:labelIds)')   // Filtre les labels par liste d'IDs.
        ->setParameter('labelIds', $labelIds)
        ->groupBy('p.id')                // Regroupe par produit.
        ->having('COUNT(DISTINCT l.id) = :nbLabels') // Vérifie que le produit a tous les labels.
        ->setParameter('nbLabels', count($labelIds)); // Nombre exact de labels attendus.
        ;
        // dd($qb->getQuery()->getResult());
    return $qb->getQuery()->getResult();

}



    /* Trouver un produit en fonction de si il est local ou pas(ne trie pas!) */

public function localProduct($localProduit){

    
    $dql=
    '
    SELECT p
    FROM App\Entity\Produit p
    WHERE p.local =:localProduit
    ';

    $query = $this->getEntityManager()->createQuery($dql);
    $query->setParameter('localProduit', $localProduit);
    
    
    return $query->getResult(); 
}




/* function pour trier avec local (si le produit est local ou affiche tout) */

public function localForm($localForm){

    $qb = $this->createQueryBuilder('p');
    
    if ($localForm == 1) {
        $qb->where('p.local = :localProduit')
        ->setParameter('localProduit', $localForm);
    }

    return $qb->getQuery()->getResult();
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
    
    return $query->getResult(); 
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


/* choisir 20 produit aléatoirement pour les catégorie  */

public function aleatProducts(int $nbProducts) { 

    $dql = 
    '
    SELECT p  
    FROM App\Entity\Produit p 
    INNER JOIN App\Entity\Categorie c
    '; 

    $query = $this->getEntityManager()->createQuery($dql); 
    /* $query->setParameter('nbProducts', $nbProducts);  */

    $query->setMaxResults($nbProducts);

    $result = $query->getResult(); 

    shuffle($result);

    return $result;
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
