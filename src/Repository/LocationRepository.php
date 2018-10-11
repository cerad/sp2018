<?php

namespace App\Repository;

use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class LocationRepository extends ServiceEntityRepository
{
  public function __construct(RegistryInterface $registry)
  {
    parent::__construct($registry, Location::class);
  }
  public function findAllOrderedByName()
  {
    return $this->getEntityManager()
      ->createQuery('SELECT p FROM App\Entity\Location p ORDER BY p.name ASC')
      ->getResult();
  }

}
