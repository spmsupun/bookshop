<?php

namespace App\Repository;

use App\Entity\InvoiceBooks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method InvoiceBooks|null find($id, $lockMode = null, $lockVersion = null)
 * @method InvoiceBooks|null findOneBy(array $criteria, array $orderBy = null)
 * @method InvoiceBooks[]    findAll()
 * @method InvoiceBooks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoiceBooksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InvoiceBooks::class);
    }

    // /**
    //  * @return InvoiceBooks[] Returns an array of InvoiceBooks objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InvoiceBooks
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
