<?php

namespace App\Repository;

use App\Entity\Location;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**  @property-read EntityManagerInterface $em */
class LocationRepository extends ServiceEntityRepository
{
  public $em;

  public function __construct(RegistryInterface $registry)
  {
    parent::__construct($registry, Location::class);

    $this->em = $this->_em;
  }

  public function findAllOrderedByName()
  {
    $qb = $this->createQueryBuilder('location');

    $qb->orderBy('location.name','ASC');

    return $qb->getQuery()->getResult();

    //return $this->getEntityManager()
    //  ->createQuery('SELECT p FROM App\Entity\Location p ORDER BY p.name ASC')
    //  ->getResult();
  }

}
