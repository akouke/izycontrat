<?php

namespace App\Repository;

use App\Entity\ActivitySector;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ActivitySector|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActivitySector|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActivitySector[]    findAll()
 * @method ActivitySector[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivitySectorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActivitySector::class);
    }

    
    public function findOneByIdActivitySector($id): ?ActivitySector
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    
    // /**
    //  * @return ActivitySector[] Returns an array of ActivitySector objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

}
