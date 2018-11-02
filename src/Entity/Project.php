<?php

declare(strict_types = 1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Project
 *
 * @ORM\Table("Project")
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
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
   * @ORM\Column(name="name", type="string", length=255)
   */
  private $name = '';

  /**
   * @var string
   *
   * @ORM\Column(name="long_name", type="string", length=255)
   */
  private $long_name = '';

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="start_date", type="date")
   */
  private $start_date;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="end_date", type="date")
   */
  private $end_date;

  /**
   * true if system should use team's region referee point rules instead of referee's region rules
   *
   * @var boolean $use_team_refpnt_rules ;
   *
   * @ORM\Column(name="use_team_refpnt_rules", type="boolean", nullable=true)
   */
  private $use_team_refpnt_rules = false;

  /**
   * @var boolean $show_referee_region ;
   *
   * @ORM\Column(name="show_referee_region", type="boolean", nullable=true)
   */
  private $show_referee_region = true;

  /**
   * @var string
   *
   * @ORM\Column(name="sportstr", type="string", length=64, nullable=true)
   */
  private $sportstr = '';

  /**
   * @ORM\ManyToMany(targetEntity="OffPos", cascade={"persist"})
   * @ORM\JoinTable(name="project_offpos",
   *      joinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName="id")},
   *      inverseJoinColumns={@ORM\JoinColumn(name="offpos_id", referencedColumnName="id")}
   *      )
   **/
  private $offpositions;

  /**
   * @var boolean $archived
   *
   * @ORM\Column(name="archived", type="boolean", nullable=true, options={"default" : 0})
   */
  private $archived = false;


  public function __construct()
  {
    $this->offpositions = new ArrayCollection();
    // setup some default positions... testing, and only useful for new projects
    $pos = new OffPos();
    $pos->setName('Referee');
    $pos->setShortname('CR');
    $pos->setDiffavail(60);
    $pos->setDiffvisable(60);
    $pos->setDiffreq(80);
    $this->offpositions->add($pos);
    $pos = new OffPos();
    $pos->setName('Asst Ref 1');
    $pos->setShortname('AR1');
    $pos->setDiffavail(80);
    $pos->setDiffvisable(80);
    $pos->setDiffreq(120);
    $this->offpositions->add($pos);
    $pos = new OffPos();
    $pos->setName('Asst Ref 2');
    $pos->setShortname('AR2');
    $pos->setDiffavail(80);
    $pos->setDiffvisable(80);
    $pos->setDiffreq(140);
    $this->offpositions->add($pos);
    $pos = new OffPos();
    $pos->setName('Standby');
    $pos->setShortname('SBY');
    $pos->setDiffavail(100);
    $pos->setDiffvisable(200);
    $pos->setDiffreq(200);
    $this->offpositions->add($pos);
    $pos = new OffPos();
    $pos->setName('4th Official');
    $pos->setShortname('4TH');
    $pos->setDiffavail(140);
    $pos->setDiffvisable(200);
    $pos->setDiffreq(200);
    $this->offpositions->add($pos);
  }

  public function getId() : int
  {
    return $this->id;
  }
  public function setId(int $id) : Project
  {
    $this->id = $id;
    return $this;
  }
  public function setName(string $name) : Project
  {
    $this->name = $name;

    return $this;
  }
  public function getName() : string
  {
    return $this->name;
  }
  public function setLongName(string $longName) : Project
  {
    $this->long_name = $longName;

    return $this;
  }
  public function getLongName() : string
  {
    return $this->long_name;
  }
  public function setStartDate(\DateTime $startDate) : Project
  {
    $this->start_date = $startDate;

    return $this;
  }
  public function getStartDate() : ?\DateTime
  {
    return $this->start_date;
  }
  public function setEndDate(\DateTime $endDate) : Project
  {
    $this->end_date = $endDate;

    return $this;
  }
  public function getEndDate() : ?\DateTime
  {
    return $this->end_date;
  }
  public function __toString() : string
  {
    return $this->getName();
  }
  public function setUseTeamRefpntRules(bool $useTeamRefpntRules) : Project
  {
    $this->use_team_refpnt_rules = $useTeamRefpntRules;

    return $this;
  }
  public function getUseTeamRefpntRules() : bool
  {
    return $this->use_team_refpnt_rules;
  }
  public function setSportstr(string $sportstr) : Project
  {
    $this->sportstr = $sportstr;

    return $this;
  }
  public function getSportstr() : ?string
  {
    return $this->sportstr;
  }
  public function addOffposition(OffPos $offposition) : Project
  {
    $this->offpositions[] = $offposition;

    return $this;
  }
  public function removeOffposition(OffPos $offposition) : void
  {
    $this->offpositions->removeElement($offposition);
  }
  public function getOffpositions() : array
  {
    // TESTING! - if no positions, populate some defaults until we add code for the user to add them.
    /*      if (count($this->offpositions) == 0)
          {
            $pos = new OffPos();
            $pos->setName('Referee');
            $pos->setShortname('CR');
            $pos->setDiffavail(60);
            $pos->setDiffvisable(60);
            $pos->setDiffreq(80);
            $this->offpositions->add($pos);
            $pos = new OffPos();
            $pos->setName('Asst Ref 1');
            $pos->setShortname('AR1');
            $pos->setDiffavail(80);
            $pos->setDiffvisable(80);
            $pos->setDiffreq(120);
            $this->offpositions->add($pos);
            $pos = new OffPos();
            $pos->setName('Asst Ref 2');
            $pos->setShortname('AR2');
            $pos->setDiffavail(80);
            $pos->setDiffvisable(80);
            $pos->setDiffreq(140);
            $this->offpositions->add($pos);
          }*/
    return $this->offpositions->toArray();
  }
  public function setShowRefereeRegion(bool $showRefereeRegion) : Project
  {
    $this->show_referee_region = $showRefereeRegion;

    return $this;
  }
  public function getShowRefereeRegion() : bool
  {
    return $this->show_referee_region;
  }
  public function setArchived(bool $archived) : Project
  {
    $this->archived = $archived;

    return $this;
  }
  public function getArchived() : bool
  {
    return $this->archived;
  }
}
