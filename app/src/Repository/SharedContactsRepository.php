<?php

namespace App\Repository;

use App\Entity\SharedContacts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SharedContacts|null find($id, $lockMode = null, $lockVersion = null)
 * @method SharedContacts|null findOneBy(array $criteria, array $orderBy = null)
 * @method SharedContacts[]    findAll()
 * @method SharedContacts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SharedContactsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SharedContacts::class);
    }

    // /**
    //  * @return SharedContacts[] Returns an array of SharedContacts objects
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
    public function findOneBySomeField($value): ?SharedContacts
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
