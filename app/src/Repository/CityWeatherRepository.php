<?php

namespace App\Repository;

use App\Entity\CityWeather;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CityWeather|null find($id, $lockMode = null, $lockVersion = null)
 * @method CityWeather|null findOneBy(array $criteria, array $orderBy = null)
 * @method CityWeather[]    findAll()
 * @method CityWeather[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CityWeatherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CityWeather::class);
    }

}
