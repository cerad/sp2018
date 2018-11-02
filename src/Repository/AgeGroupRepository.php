<?php

declare(strict_types = 1);

namespace App\Repository;

use App\Entity\AgeGroup;
use App\Entity\Project;
use App\Entity\Region;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**  @property-read EntityManagerInterface $em */
class AgeGroupRepository extends ServiceEntityRepository
{
  public $em;

  public function __construct(RegistryInterface $registry)
  {
    parent::__construct($registry, AgeGroup::class);

    $this->em = $this->_em;
  }
  public function findAllOrderedByName()
  {
    $qb = $this->createQueryBuilder('ag');

    $qb->orderBy('ag.name','ASC');

    return $qb->getQuery()->getResult();
  }
}
