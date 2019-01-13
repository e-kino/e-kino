<?php

namespace App\Repository;

use App\Entity\Programme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ProgrammeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Programme::class);
    }

    /**
     * Returns current programme
     * @return null|Programme
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findCurrentProgramme()
    {
        $now = date('Y-m-d H:i:s');

        $qb = $this->createQueryBuilder('p')
            ->andWhere('p.dateStart <= :date')
            ->andWhere('p.dateEnd >= :date')
            ->setParameter('date', $now)
            ->getQuery();

        return $qb->setMaxResults(1)->getOneOrNullResult();
    }
}
