<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<Utilisateur>
 */
class UtilisateurRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Utilisateur) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
    //    /**
    //     * @return Utilisateur[] Returns an array of Utilisateur objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Utilisateur
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }


    /* Function pour afficher les produit de l'utilisateur en favoris */
    public function productInFavoris()
    {
    
        


    }


    /* Function pour afficher l'historique d'achat du client */
    public function productInHistorique($utilisateur)
    {
        $dql=
        '
        SELECT p
        FROM App\Entity\produit p
        INNER JOIN App\Entity\Commande c 
        inner join App\Entity\Utilisateur u
        WHERE u.id =:utilisateur
        ORDER BY p.id ASC
        
        ';

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('utilisateur', $utilisateur);
    
    dd($query->getResult());
    return $query->getResult(); 

        
    }
}


/* SELECT * FROM produit as p 
INNER JOIN commande_produit as cp ON p.id=produit_id
INNER JOIN commande as c ON commande_id=c.id
WHERE utilisateur_id=1062
ORDER BY p.id ASC; */