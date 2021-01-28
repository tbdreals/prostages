<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

    // /**
    //  * @return Stage[] Returns an array of Stage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /**
     * @return Stage[] Returns an array of Stage objects
     */

    public function findByNomEntreprise($nom)
    {
        return $this->createQueryBuilder('s')
            ->join('s.entreprise', 'e')
            ->where('e.nom = :nom')
            ->setParameter('nom', $nom)
            ->getQuery()
            ->getResult()
        ;
    }


    /**
     * @return Stage[] Returns an array of Stage objects
     */

    public function findByNomFormation($nom)
    {
        // On récupère l'entity manager
        $entityManager = $this->getEntityManager();

        // On crée la requête pour récupérer les stages proposés pour la formation dont le nom est donné en paramètre
        $requete = $entityManager->createQuery('SELECT s, f FROM App\Entity\Stage s JOIN s.formations f WHERE f.intitule = :nom');

        // On remplit les paramètres de la requête
        $requete->setParameter('nom', $nom);

        // On execute et retourne la requête
        return $requete->execute();
    }

    /*
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
