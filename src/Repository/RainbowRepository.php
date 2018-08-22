<?php

namespace App\Repository;

use App\Entity\Rainbow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Rainbow|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rainbow|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rainbow[]    findAll()
 * @method Rainbow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RainbowRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Rainbow::class);
    }

//    /**
//     * @return Rainbow[] Returns an array of Rainbow objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Rainbow
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
