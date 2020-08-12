<?php

namespace App\Repository;

use App\Entity\EmailNewsletter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EmailNewsletter|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmailNewsletter|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmailNewsletter[]    findAll()
 * @method EmailNewsletter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailNewsletterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailNewsletter::class);
    }

    public function getEmail() {

        return $this->createQueryBuilder("e")
            ->addOrderBy("e.email")
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return EmailNewsletter[] Returns an array of EmailNewsletter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EmailNewsletter
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
