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



    /* Function pour afficher l'historique produit de l'utilisateur  */
    public function productInHistorique($utilisateurHistorique)
    {
    
        $dql = '
        SELECT p
        FROM App\Entity\Produit p
        INNER JOIN p.commandes c
        INNER JOIN c.utilisateur u
        WHERE u.id = :utilisateurHistorique
        ';
        $query = $this->getEntityManager()->createQuery($dql)
                ->setParameter('utilisateurHistorique', $utilisateurHistorique)
                ->getResult();

        return $query;


    }


    /* Function pour afficher les produit favoris des client */
    public function productInFavoris($utilisateurFavoris)
    {
        
    $dql = '
    SELECT p
    FROM App\Entity\Produit p
    INNER JOIN p.utilisateurs u
    WHERE u.id = :utilisateurFavoris
    ';
    $query = $this->getEntityManager()->createQuery($dql)
            ->setParameter('utilisateurFavoris', $utilisateurFavoris)
            ->getResult();

<<<<<<< Updated upstream
    // dd($query);
    return $query;
=======
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('utilisateur', $utilisateur);
    
    // dd($query->getResult());
    return $query->getResult(); 
>>>>>>> Stashed changes

    }
}
