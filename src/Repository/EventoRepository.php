<?php

namespace App\Repository;

use App\Entity\Evento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class EventoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Evento::class);
    }

    public function findByDateAndSearch($date, $searchtype, $search){
        return $this->createQueryBuilder('e')
            ->where('e.start > :value')->setParameter('value', $date)
            ->orderBy('e.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    public function findByDate($date)
    {
        return $this->createQueryBuilder('e')
            ->where('e.start > :value')->setParameter('value', $date)
            ->orderBy('e.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

}
