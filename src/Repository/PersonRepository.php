<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Person|null find($id, $lockMode = null, $lockVersion = null)
 * @method Person|null findOneBy(array $criteria, array $orderBy = null)
 * @method Person[]    findAll()
 * @method Person[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }
    
    // public function findOneByLastPerson($value): ?Company
    // {
    //     return $this->createQueryBuilder('c')
    //         ->andWhere('c.user = :val and c.id = c.associates')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         // ->getOneOrNullResult()
    //         ->getResult()
    //     ;
    // }
    
    /**
      * @return Person[] Returns an array of Person objects
      */
    public function findLastPerson($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.user = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }
}
