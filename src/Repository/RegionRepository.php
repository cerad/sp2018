<?php

namespace App\Repository;

use App\Entity\Region;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**  @property-read EntityManagerInterface $em */
class RegionRepository extends ServiceEntityRepository
{
  public $em;

  public function __construct(RegistryInterface $registry)
  {
    parent::__construct($registry, Region::class);

    $this->em = $this->_em;
  }

  public function findAllOrderedByName()
  {
    $qb = $this->createQueryBuilder('region');

    $qb->orderBy('region.name','ASC');

    return $qb->getQuery()->getResult();
  }

}
