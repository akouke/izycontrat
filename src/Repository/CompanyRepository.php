<?php

namespace App\Repository;

use App\Entity\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

     /**
      * @return Company[] Returns an array of Company objects
      */
    public function findLastCompany($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.client = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }
    
    // public function findOneByLastCompany($value): ?Company
    // {
    //     return $this->createQueryBuilder('c')
    //         ->andWhere('c.client = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('c.id', 'ASC')
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }
    
}
