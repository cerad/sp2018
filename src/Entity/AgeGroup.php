<?php

declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * App\Entity\AgeGroup
 *
 * @ORM\Table("AgeGroup")
 * @ORM\Entity(repositoryClass="App\Repository\AgeGroupRepository")
 * @UniqueEntity(
 *     fields={"name", "project", "region"},
 *     ignoreNull=true,
 *     message="AgeGroup Name must be unique inside a region and project"
 * )
 */
class AgeGroup
{

  /**
   * @var integer $id
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var string $name
   *
   * @Assert\NotBlank()
   *
   * @ORM\Column(name="name", type="string", length=32)
   */
  private $name = '';

  /**
   * @var Region $region
   *
   * @ORM\ManyToOne(targetEntity="Region")
   * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
   */
  private $region;

  /**
   * @var Project $project
   *
   * @ORM\ManyToOne(targetEntity="Project")
   * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
   */
  private $project;

  /**
   * @var integer $difficulty
   *
   * @ORM\Column(name="difficulty", type="integer")
   */
  private $difficulty = 0;

  /**
   * @var integer $points_multiplier
   *
   * @ORM\Column(name="points_multiplier", type="integer")
   */
  private $points_multiplier = 0;

  /**
   * @var integer $points_ref1
   *
   * @ORM\Column(name="points_ref1", type="integer")
   */
  private $points_ref1 = 0;

  /**
   * @var integer $points_youth_ref1
   *
   * @ORM\Column(name="points_youth_ref1", type="integer")
   */
  private $points_youth_ref1 = 0;

  /**
   * @var integer $points_ref2
   *
   * @ORM\Column(name="points_ref2", type="integer")
   */
  private $points_ref2 = 0;

  /**
   * @var integer $points_youth_ref2
   *
   * @ORM\Column(name="points_youth_ref2", type="integer")
   */
  private $points_youth_ref2 = 0;

  /**
   * @var integer $points_ref3
   *
   * @ORM\Column(name="points_ref3", type="integer")
   */
  private $points_ref3 = 0;

  /**
   * @var integer $points_youth_ref3
   *
   * @ORM\Column(name="points_youth_ref3", type="integer")
   */
  private $points_youth_ref3 = 0;

  /**
   * @var integer $points_team_goal
   *
   * @ORM\Column(name="points_team_goal", type="integer")
   */
  private $points_team_goal = 0;


  public function __construct()
  {
    $this->points_multiplier = 1;
    $this->points_ref1 = 1;
    $this->points_youth_ref1 = 1;
    $this->points_ref2 = 1;
    $this->points_youth_ref2 = 1;
    $this->points_ref3 = 1;
    $this->points_youth_ref3 = 1;
    $this->points_team_goal = 0;
  }

  public function pointsNonZero() : bool
  {
    return
      ($this->points_ref1 > 0) ||
      ($this->points_ref2 > 0) ||
      ($this->points_ref3 > 0) ||
      ($this->points_youth_ref1 > 0) ||
      ($this->points_youth_ref2 > 0) ||
      ($this->points_youth_ref3 > 0);
  }

  public function getId() : int
  {
    return $this->id;
  }
  public function setId(int $id) : AgeGroup
  {
    $this->id = $id;
    return $this;
  }
  public function setName(string $name) : AgeGroup
  {
    $this->name = $name;

    return $this;
  }
  public function getName() : string
  {
    return $this->name;
  }
  public function setDifficulty(int $difficulty) : AgeGroup
  {
    $this->difficulty = $difficulty;

    return $this;
  }
  public function getDifficulty() : int
  {
    return $this->difficulty;
  }
  public function __toString() : string
  {
    if ($this->getRegion())
      return $this->getRegion()->getName() . ' ' . $this->getName();
    else
      return 'NA ' . $this->getName();
  }
  public function setPointsMultiplier(int $pointsMultiplier) : AgeGroup
  {
    $this->points_multiplier = $pointsMultiplier;

    return $this;
  }
  public function getPointsMultiplier() : int
  {
    return $this->points_multiplier;
  }
  public function setProject(Project $project) : AgeGroup
  {
    $this->project = $project;

    return $this;
  }
  public function getProject() : ?Project
  {
    return $this->project;
  }
  public function setRegion(Region $region) : AgeGroup
  {
    $this->region = $region;

    return $this;
  }
  public function getRegion() : ?Region
  {
    return $this->region;
  }
  public function setPointsRef1(int $pointsRef1) : AgeGroup
  {
    $this->points_ref1 = $pointsRef1;

    return $this;
  }
  public function getPointsRef1() : int
  {
    return $this->points_ref1;
  }
  public function setPointsYouthRef1(int $pointsYouthRef1) : AgeGroup
  {
    $this->points_youth_ref1 = $pointsYouthRef1;

    return $this;
  }
  public function getPointsYouthRef1() : int
  {
    return $this->points_youth_ref1;
  }
  public function setPointsRef2(int $pointsRef2) : AgeGroup
  {
    $this->points_ref2 = $pointsRef2;

    return $this;
  }
  public function getPointsRef2() : int
  {
    return $this->points_ref2;
  }
  public function setPointsYouthRef2(int $pointsYouthRef2) : AgeGroup
  {
    $this->points_youth_ref2 = $pointsYouthRef2;

    return $this;
  }
  public function getPointsYouthRef2() : int
  {
    return $this->points_youth_ref2;
  }
  public function setPointsRef3(int $pointsRef3) : AgeGroup
  {
    $this->points_ref3 = $pointsRef3;

    return $this;
  }
  public function getPointsRef3() : int
  {
    return $this->points_ref3;
  }
  public function setPointsYouthRef3(int $pointsYouthRef3) : AgeGroup
  {
    $this->points_youth_ref3 = $pointsYouthRef3;

    return $this;
  }
  public function getPointsYouthRef3() : int
  {
    return $this->points_youth_ref3;
  }
  public function setPointsTeamGoal(int $pointsTeamGoal) : AgeGroup
  {
    $this->points_team_goal = $pointsTeamGoal;

    return $this;
  }
  public function getPointsTeamGoal() : int
  {
    return $this->points_team_goal;
  }
}