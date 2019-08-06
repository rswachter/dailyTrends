<?php

namespace App\Repository;

use App\Entity\Feed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Feed|null find($id, $lockMode = null, $lockVersion = null)
 * @method Feed|null findOneBy(array $criteria, array $orderBy = null)
 * @method Feed[]    findAll()
 * @method Feed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeedRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Feed::class);
    }

    // /**
    //  * @return Feed[] Returns an array of Feed objects
    //  */
    public function findIndexFeed()
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.publisher LIKE :elpais OR f.publisher LIKE :elmundo')
            ->orderBy('f.id', 'DESC')
            ->setMaxResults(10)
            ->setParameter('elpais', 'El Pais')
            ->setParameter('elmundo', 'El Mundo')
            ->getQuery()
            ->execute();
    }
}
