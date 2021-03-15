<?php

namespace App\Repository;

use App\Entity\Susbcription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Susbcription|null find($id, $lockMode = null, $lockVersion = null)
 * @method Susbcription|null findOneBy(array $criteria, array $orderBy = null)
 * @method Susbcription[]    findAll()
 * @method Susbcription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SusbcriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Susbcription::class);
    }

    // /**
    //  * @return Susbcription[] Returns an array of Susbcription objects
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

    /*
    public function findOneBySomeField($value): ?Susbcription
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
