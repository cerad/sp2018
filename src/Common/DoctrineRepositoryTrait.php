<?php
/** @noinspection PhpUndefinedFieldInspection */
declare(strict_types = 1);

namespace App\Common;

/* =====================================
 * Keep for now as an example
 * Think just having a public $em is better
 */
trait DoctrineRepositoryTrait
{
  public function flush($entity = null)
  {
    $this->_em->flush($entity);
  }
  public function persist($entity)
  {
    $this->_em->persist($entity);
  }
  public function remove($entity)
  {
    $this->_em->remove($entity);
  }
}