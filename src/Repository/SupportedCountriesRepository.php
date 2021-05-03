<?php

namespace App\Repository;

use App\Entity\SupportedCountries;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SupportedCountries|null find($id, $lockMode = null, $lockVersion = null)
 * @method SupportedCountries|null findOneBy(array $criteria, array $orderBy = null)
 * @method SupportedCountries[]    findAll()
 * @method SupportedCountries[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupportedCountriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SupportedCountries::class);
    }
}
