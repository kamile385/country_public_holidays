<?php

namespace App\Repository;

use App\Entity\HolidaysForYear;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HolidaysForYear|null find($id, $lockMode = null, $lockVersion = null)
 * @method HolidaysForYear|null findOneBy(array $criteria, array $orderBy = null)
 * @method HolidaysForYear[]    findAll()
 * @method HolidaysForYear[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HolidaysForYearRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HolidaysForYear::class);
    }

}
