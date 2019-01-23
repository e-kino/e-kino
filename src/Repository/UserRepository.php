<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Get users by the role.
     * @param $userRoleId
     * The role id to search users.
     * @return null|User
     */
    public function findByRoleId($userRoleId)
    {
        $qb = $this->createQueryBuilder('user')
                    ->select('user')
                    ->andWhere('user.role_id == :userRole')
                    ->andWhere("user.active == '1'")
                    ->setParameter('userRole', $userRoleId)
                    ->getQuery();

        return $qb->getResult();
    }

    /**
     * Get user by the email.
     * @param $userEmail
     * The user email to find the user.
     * @return null|User
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByEmail($userEmail)
    {
        $qb = $this->createQueryBuilder('user')
                    ->select('user')
                    ->Where('user.email == :email')
                    ->setParameter('email', $userEmail)
                    ->getQuery();

        return $qb->setMaxResults(1)
                  ->getOneOrNullResult();
    }
      /**
     * Get user by the email and password.
     * @param $userEmail,$userPass
     * Find the user with email and password.
     * @return null|User
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByEmailPass($userEmail,$userPass)
    {
         $qb = $this->createQueryBuilder('user')
                    ->select('user')
                    ->andWhere('user.email == :email')
                    ->andWhere('user.password == :pass')
                    ->setParameter('email', $userEmail)
                    ->setParameter('pass', $userPass)
                    ->getQuery();

        return $qb->setMaxResults(1)
                  ->getOneOrNullResult();
       
    }
}
