<?php

namespace App\Repository;

use App\Entity\SousCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SousCategorie>
 */
class SousCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SousCategorie::class);
    }



      /* appel les sous catégorie */
     public function showSousCategory(int $sousCategory) : array
     {
         
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT s
            FROM App\Entity\SousCategorie s
            WHERE s.slug = :sousCategorie'
        )->setParameter('sousCategorie', $sousCategory) ;
     
        return $query->getResult();
         
 
     }

        /* public function findProductsBySousCategoryWithPagination(string $sousCategory, int $offset, int $limit)
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
        } */

        /* appel les sous categorie d'une catégorie */
        public function getSousCategoriesFromCategory(int $category) : array
        {

            $entityManager = $this->getEntityManager();
            $query = $entityManager->createQuery(                                   
                'SELECT s       
                FROM App\Entity\SousCategorie s
                WHERE s.categorie = :categorie'
            )->setParameter('categorie', $category) ;
        
            return $query->getResult();

    
        }

         /* appel les sous categorie d'une catégorie */
         public function getSousCategoriesId(string $sousCategory) : array
         {
 
             $entityManager = $this->getEntityManager();
             $query = $entityManager->createQuery(
                 'SELECT s.id
                 FROM App\Entity\SousCategorie s
                 WHERE s.slug = :sousCategory'
             )->setParameter('sousCategory', $sousCategory) ;
         
             return $query->getResult();
 
     
         }
    
    //    /**
    //     * @return SousCategorie[] Returns an array of SousCategorie objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?SousCategorie
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
