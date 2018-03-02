<?php

namespace App\Repository;

use App\Entity\Movies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Movies|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movies|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movies[]    findAll()
 * @method Movies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoviesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Movies::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('m')
            ->where('m.something = :value')->setParameter('value', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    /**
     * @param null $date_released
     * @param null $genre
     * @param null $rating
     * @param null $asArray
     * @return Movies []
     */
    public function searchAllBy($date_released = null, $genre = null, $rating= null, $asArray = null): array
    {

        ;

        if ($date_released) {
            $qb = $this->createQueryBuilder('m')->andWhere('m.date_released = :date_released')->setParameter('date_released', $date_released)->getQuery();
        }

        if ($genre) {
            $qb = $this->createQueryBuilder('m')->andWhere('m.genre = :genre')->setParameter('genre', $genre)->getQuery();
        }

        if ($rating) {
            $qb = $this->createQueryBuilder('m')->andWhere('m.rating = :rating')->setParameter('rating', $rating)->getQuery();
        }



        if ($asArray)
            return $qb->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        else
            return $qb->execute();
    }///end of  public function searchAllBy($release_date = null, $genre = null, $rating= null, $asArray = null): array






}
