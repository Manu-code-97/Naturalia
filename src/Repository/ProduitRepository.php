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
public function findProductsByCategoryWithPagination(string $category, int $offset, int $limit)
{
    return $this->createQueryBuilder('p')
        ->innerJoin('p.sousCategorie', 's')
        ->innerJoin('s.categorie', 'c')
        ->andWhere('c.slug = :category')
        ->setParameter('category', $category)
        ->orderBy('p.id', 'DESC')
        ->setFirstResult($offset)
        ->setMaxResults($limit)
        ->getQuery()
        ->getResult();
}

public function findProductsBySousCategoryWithPagination(string $sousCategory, int $offset, int $limit)
        {
            return $this->createQueryBuilder('p')
                ->innerJoin('p.sousCategorie', 's')
                ->andWhere('s.slug = :sousCategory')
                ->setParameter('sousCategory', $sousCategory)
                ->orderBy('p.id', 'DESC')
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();
        }

    
    /* Fonction pour trouver des produit par rappor a sa catégorie dans le product controller */
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!! ne retourne pas des produits !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
public function findProductsByCategory($productCategory)
{
    $dql = '
        SELECT p
        FROM App\Entity\Produit p
        INNER JOIN p.sousCategorie s
        INNER JOIN s.categorie c
        WHERE c.slug = :productCategory
    ';

    $query = $this->getEntityManager()->createQuery($dql);
    $query->setParameter('productCategory', $productCategory);

    return $query->getResult();
}



/* Function pour filtrer par label et local */
public function filterByLabelAndLocal($localForm , $labelIds, $categoryId = null, $sousCategoryId = null)
{
    $qb = $this->createQueryBuilder('p');

    // Filtrage local
    if ($localForm == 1) {
        $qb->andWhere('p.local = :localProduit')
            ->setParameter('localProduit', $localForm);
    }

    // Filtrage par labels
    if (!empty($labelIds)) {
        $qb->join('p.label', 'l')
            ->andWhere('l.id IN (:labelIds)')
            ->setParameter('labelIds', $labelIds)
            ->groupBy('p.id')
            ->having('COUNT(DISTINCT l.id) = :nbLabels')
            ->setParameter('nbLabels', count($labelIds));
    }

    // Filtrage par sous-catégorie ou catégorie principale
    if ($sousCategoryId) {
        $qb->join('p.sousCategorie', 'sc')
            ->andWhere('sc.slug = :sousCategorySlug')
            ->setParameter('sousCategorySlug', $sousCategoryId);
    }
    
    if (!empty($categoryId)) {
        $qb->join('p.sousCategorie', 'cat')
            ->andWhere('cat.categorie IN (:categoryId)')
            ->setParameter('categoryId', $categoryId);
    }

    
    // dd($qb->getQuery()->getResult());          

    // Exécution de la requête
    return $qb->getQuery()->getResult();
}



/* trier par nom croissant et décroissant  */
public function nameTrie($nomProduit , $categoryId = null, $sousCategoryId = null){

    
    $dql = $this->createQueryBuilder('p'); 

    if (!empty($nomProduit)) {
        $dql->andWhere('p.nom = :nomProduit')
        ->setParameter('nomProduit', $nomProduit);
    }
    
    

    // Filtrage par sous-catégorie ou catégorie principale
    if (!empty($sousCategoryId)) {
        $dql->join('p.sousCategorie', 'sc')
            ->andWhere('sc.id = :sousCategoryId')
            ->setParameter('sousCategoryId', $sousCategoryId);
    }
    
    if (!empty($categoryId)) {
        $dql->join('p.sousCategorie', 'cat')
            ->andWhere('cat.categorie IN (:categoryId)')
            ->setParameter('categoryId', $categoryId);
    }
    
    $dql->orderBy('p.nom', 'ASC')
        ->addOrderBy('p.nom', 'DESC');


        $query = $dql->getQuery();
        
        return $query->getResult(); 
}



/* trier par prix croissant et décroissant  */
public function priceTrie($prixProduit , $categoryId = null, $sousCategoryId = null){

    $dql = $this->createQueryBuilder('p'); 

    if (!empty($prixProduit)) {
        $dql->where('p.prix = :prixProduit')
        ->setParameter('prixProduit', $prixProduit);
    }
    
    

    // Filtrage par sous-catégorie ou catégorie principale
    if (!empty($sousCategoryId)) {
        $dql->join('p.sousCategorie', 'sc')
            ->andWhere('sc.id = :sousCategorySlug')
            ->setParameter('sousCategorySlug', $sousCategoryId);
    }
    
    if (!empty($categoryId)) {
        $dql->join('p.sousCategorie', 'cat')
            ->andWhere('cat.categorie IN (:categoryId)')
            ->setParameter('categoryId', $categoryId);
    }
    
    $dql->orderBy('p.nom', 'ASC')
        ->addOrderBy('p.nom', 'DESC');

        $query = $dql->getQuery();
        // dd($query->getResult());
        
        return $query->getResult(); 
}


/* choisir 20 produit aléatoirement pour les catégorie non utiliser pour le moment  */

public function aleatProducts(int $nbProducts) { 

    $dql = '
    SELECT p
    FROM App\Entity\Produit p
'; 


        $query = $this->getEntityManager()->createQuery($dql);

        $result = $query->getResult();

        shuffle($result);

        $randomProducts = array_slice($result, 0, $nbProducts);
        
        
        // dd($randomProducts);

        return $randomProducts;
    }



    public function findByQuery(string $query)
{
    return $this->createQueryBuilder('p')
        ->where('p.nom LIKE :query')
        ->setParameter('query', '%' . $query . '%')
        ->getQuery()
        ->getResult();
}



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

