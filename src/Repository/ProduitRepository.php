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



public function getProductsOnPromotion(): array
{
  /*   $entityManager = $this->getEntityManager();
    $query = $entityManager->createQuery(
        'SELECT p
        FROM App\Entity\Produit p
        WHERE p.promotion is NULL
        -- ORDER BY p.price DESC
    '
    );

    return $query->getResult(); */
    return [];
}


public function findProductsBySousCategory($sousCategory) { 

    $dql = '
    SELECT p 
    FROM App\Entity\Produit p 
    WHERE p.sousCategorie = :sousCategory'; 
    
    $query = $this->getEntityManager()->createQuery($dql); 
    $query->setParameter('sousCategory', $sousCategory); 
    
    return $query->getResult(); 
}












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
