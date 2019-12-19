<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    public function getBestMovie()
    {
        $qb = $this->createQueryBuilder('p');

        $qb->innerJoin('p.user', 'u')
           ->groupBy('p.id')
           ->orderBy('count(p.id)', 'DESC')
           ->setMaxResults(1);

        $query = $qb->getQuery();

        return $query->getScalarResult();
    }
}
