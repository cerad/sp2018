<?php

declare(strict_types = 1);

namespace App\Repository;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**  @property-read EntityManagerInterface $em */
class ProjectRepository extends ServiceEntityRepository
{
  public $em;

  public function __construct(RegistryInterface $registry)
  {
    parent::__construct($registry, Project::class);

    $this->em = $this->_em;
  }

  public function findAllOrderedByDate()
  {
    $qb = $this->createQueryBuilder('project');

    $qb->orderBy('project.archived','ASC');
    $qb->orderBy('project.start_date','DESC');
    $qb->orderBy('project.end_date','DESC');

    return $qb->getQuery()->getResult();
  }

}
