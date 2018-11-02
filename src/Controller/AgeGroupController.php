<?php

declare(strict_types = 1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use App\Entity\AgeGroup;
use App\Entity\Project;
use App\Form\AgeGroupType;
//e App\Form\ProjectDeleteType;
use App\Repository\AgeGroupRepository;

/**
 * AgeGroup controller.
 *
 * @Route("/agegroup")
 */
class AgeGroupController extends AbstractController
{
  private $title = 'Age Groups';

  /** @var AgeGroupRepository */
  private $ageGroupRepository;

  public function __construct(AgeGroupRepository $ageGroupRepository)
  {
    $this->ageGroupRepository = $ageGroupRepository;
  }
  /**
   * Lists all AgeGroup entities. (for debugging purposes)
   *
   * @Route("/all", name="agegroup_all")
   */
  public function allAction()
  {
    $ageGroups = $this->ageGroupRepository->findAllOrderedByName();

    return $this->render('agegroup/list.html.twig',
      [
        'title'     => $this->title,
        'ageGroups' => $ageGroups,
      ]);
  }
  /**
   * Updates AgeGroup entity.
   *
   * @Route("/update/{id}", name="agegroup_update")
   */
  public function updateAction(Request $request, AgeGroup $ageGroup)
  {
  }
}
