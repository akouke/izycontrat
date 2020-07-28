<?php

namespace App\Repository;

use App\Entity\CompaniesTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompaniesTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompaniesTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompaniesTypes[]    findAll()
 * @method CompaniesTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompaniesTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompaniesTypes::class);
    }

    // /**
    //  * @return CompaniesTypes[] Returns an array of CompaniesTypes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function findOneByName($value): ?CompaniesTypes
    {
        return $this->createQueryBuilder('c')
            ->where('c.name = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}
