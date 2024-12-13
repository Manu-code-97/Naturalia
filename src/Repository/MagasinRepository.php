<?php

namespace App\Repository;

use App\Entity\Magasin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Magasin>
 */
class MagasinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Magasin::class);
    }

        /**
        * @return Magasin[] Returns an array of Magasin objects
        */
        public function getAllStores(): array
        {
            $dql = '
            SELECT m
            FROM App\Entity\Magasin m
            ';

            $query = $this->getEntityManager()->createQuery($dql)->getResult();
            
            // dd($query);
            return $query;
        }

    //    public function findOneBySomeField($value): ?Magasin
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
