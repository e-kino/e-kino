<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class MovieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    /**
     * Returns movie by name
     * @param $name
     * @return null|Movie
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByName($name)
    {
        $qb = $this->createQueryBuilder('m')
            ->andWhere('p.name == :name')
            ->setParameter('name', $name)
            ->getQuery();

        return $qb->setMaxResults(1)->getOneOrNullResult();
    }
}

