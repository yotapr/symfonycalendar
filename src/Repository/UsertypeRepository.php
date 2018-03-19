<?php

namespace App\Repository;

use App\Entity\Usertype;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Usertype|null find($id, $lockMode = null, $lockVersion = null)
 * @method Usertype|null findOneBy(array $criteria, array $orderBy = null)
 * @method Usertype[]    findAll()
 * @method Usertype[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsertypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Usertype::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('u')
            ->where('u.something = :value')->setParameter('value', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
