<?php

namespace App\Controller;

use App\Form\RegionDeleteType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Region;
use App\Form\RegionType;
use App\Repository\RegionRepository;

/**
 * Region controller.
 *
 * @Route("/region")
 */
class RegionController extends AbstractController
{
  /** @var RegionRepository */
  private $regionRepository;

  public function __construct(RegionRepository $regionRepository)
  {
    $this->regionRepository = $regionRepository;
  }

  /**
   * Lists all Region entities.
   *
   * @Route("/list", name="region_list")
   */
  public function listAction()
  {
    $regions = $this->regionRepository->findAllOrderedByName();

    return $this->render('region/list.html.twig',
      [
        'title'   => 'Regions',
        'regions' => $regions,
      ]);
  }

  /**
   * Finds and displays a Region entity.
   *
   * @Route("/show/{id}", name="region_show")
   */
  public function showAction(Region $region)
  {
    $deleteForm = $this->createForm(RegionDeleteType::class, $region);

    return $this->render('region/show.html.twig',
      [
        'title'  => 'Regions',
        'region' => $region,
        'delete_form' => $deleteForm->createView(),
      ]);
  }

  /**
   * Creates a new Region entity.
   *
   * @Route("/create", name="region_create")
   */
  public function createAction(Request $request)
  {
    $region = new Region();
    $form = $this->createForm(RegionType::class, $region);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $this->regionRepository->em->persist($region);
      $this->regionRepository->em->flush();

      return $this->redirectToRoute('region_update', ['id' => $region->getId()]);
    }
    return $this->render('region/create.html.twig',
      [
        'title'  => 'Regions',
        'region' => $region,
        'form'   => $form->createView(),
      ]);
  }

  /**
   * Edits an existing Region entity.
   *
   * @Route("/update/{id}", name="region_update")
   */
  public function updateAction(Request $request, Region $region)
  {
    $updateForm = $this->createForm(RegionType::class, $region);
    $deleteForm = $this->createForm(RegionDeleteType::class, $region);

    $updateForm->handleRequest($request);

    if ($updateForm->isSubmitted() && $updateForm->isValid()) {

      $this->regionRepository->em->persist($region);
      $this->regionRepository->em->flush();

      return $this->redirectToRoute('region_update', ['id' => $region->getId()]);
    }

    return $this->render('region/update.html.twig',
      [
        'title'  => 'Regions',
        'region' => $region,
        'update_form' => $updateForm->createView(),
        'delete_form' => $deleteForm->createView(),
      ]);
  }

  /**
   * Deletes a Region entity.
   *
   * @Route("/delete/{id}", name="region_delete", methods={"POST"})
   */
  public function deleteAction(Request $request, Region $region)
  {
    $form = $this->createForm(RegionDeleteType::class, $region);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->regionRepository->em->remove($region);
      $this->regionRepository->em->flush();
    }

    return $this->redirectToRoute('region_list');
  }

}
