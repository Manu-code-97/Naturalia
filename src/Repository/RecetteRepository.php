<?php

namespace App\Repository;

use App\Entity\Recette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\BrowserKit\Response;

/**
 * @extends ServiceEntityRepository<Recette>
 */
class RecetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recette::class);
    }

// Dans cette partie je crée une fonction pour afficher mes differentes recettes !

  // Dans cette partie je crée une fonction pour afficher les differentes recettes !



// function pour Récupère un nombre défini de recettes aléatoires
  
public function findRandomRecipe(): Recette
{
    // Récupérer une recette aléatoire directement avec DQL
    $dql = 
    'SELECT r 
    FROM App\Entity\Recette r';

    $query = $this->getEntityManager()->createQuery($dql)->getResult();

    $randomRecette = $query[rand(0,count($query)-1)];
    
    return $randomRecette;
}

public function findProductsByRecetteId($recette_id)
{ 

    $dql = '
    SELECT p
    FROM App\Entity\Produit p
    INNER JOIN p.recettes r
    WHERE r.id = :recette_id
    ';
    $query = $this->getEntityManager()->createQuery($dql)
            ->setParameter('recette_id', $recette_id)
            ->getResult();

    // dd($query);
    return $query;
}




// fonction pour afficher une recette en particulier 

    // en dessus ce qui est deja commenter en Amont

    //    /**
    //     * @return Recette[] Returns an array of Recette objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Recette
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
