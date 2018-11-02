<?php

declare(strict_types = 1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * OffTeam
 *
 * @ORM\Table("OffTeam")
 * @ORM\Entity
 */
class OffTeam
{
  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var string
   *
   * @ORM\Column(name="name", type="string", length=64)
   */
  private $name;

  /**
   * @ORM\ManyToMany(targetEntity="OffPos", cascade={"persist"})
   * @ORM\JoinTable(name="offteam_offpos",
   *      joinColumns={@ORM\JoinColumn(name="offteam_id", referencedColumnName="id")},
   *      inverseJoinColumns={@ORM\JoinColumn(name="offpos_id", referencedColumnName="id")}
   *      )
   **/
  private $positions;


  public function __construct()
  {
    $this->positions = new ArrayCollection();
  }

  /**
   * Get id
   *
   */
  public function getId() : int
  {
    return $this->id;
  }

  /**
   * Set name
   *
   */
  public function setName(string $name) : OffTeam
  {
    $this->name = $name;

    return $this;
  }

  /**
   * Get name
   *
   */
  public function getName() : string
  {
    return $this->name;
  }

  /**
   * Add position
   */
  public function addPosition(OffPos $position) : OffTeam
  {
    $this->positions[] = $position;

    return $this;
  }

  /**
   * Remove position
   *
   */
  public function removePosition(OffPos $position)
  {
    $this->positions->removeElement($position);
  }

  /**
   * Get positions
   *
   */
  public function getPositions() : ArrayCollection
  {
    return $this->positions;
  }

  public function __toString() : string
  {
    return $this->getName();
  }

}
