<?php

namespace App\Repository;

use App\Entity\Phonebook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Phonebook|null find($id, $lockMode = null, $lockVersion = null)
 * @method Phonebook|null findOneBy(array $criteria, array $orderBy = null)
 * @method Phonebook[]    findAll()
 * @method Phonebook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhonebookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Phonebook::class);
    }


}
