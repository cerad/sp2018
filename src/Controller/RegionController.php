<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
  private function findRegion(int $id)
  {
    $region = $this->regionRepository->find($id);
    if (!$region) {
      throw $this->createNotFoundException('Unable to find Region entity.');
    }
    return $region;
  }

  /**
   * Lists all Region entities.
   *
   * @Route("/", name="region")
   */
  public function indexAction()
  {
    $regions = $this->regionRepository->findAllOrderedByName();

    return $this->render('region/index.html.twig',
      [
        'title'   => 'Regions',
        'regions' => $regions,
      ]);
  }

  /**
   * Finds and displays a Region entity.
   *
   * @Route("/{id}/show", name="region_show")
   */
  public function showAction($id)
  {
    $region = $this->findRegion($id);

    $deleteForm = $this->createDeleteForm($id);

    return $this->render('region/show.html.twig',
      [
        'title'  => 'Regions',
        'region' => $region,
        'delete_form' => $deleteForm->createView(),
      ]);
  }

  /**
   * Displays a form to create a new Region entity.
   *
   * @Route("/new", name="region_new")
   * @Template()
   */
  public function newAction()
  {
    $region = new Region();
    $form = $this->createForm(RegionType::class, $region);

    return [
      'title'  => 'Regions',
      'region' => $region,
      'form'   => $form->createView(),
    ];
  }

  /**
   * Creates a new Region entity.
   *
   * @Route("/create", name="region_create")
   * @Template("region/new.html.twig")
   */
  public function createAction(Request $request)
  {
    $region = new Region();
    $form = $this->createForm(RegionType::class, $region);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $this->regionRepository->em->persist($region);
      $this->regionRepository->em->flush();

      return $this->redirectToRoute('region_show', ['id' => $region->getId()]);
    }

    return [
      'title'  => 'Regions',
      'region' => $region,
      'form'   => $form->createView(),
    ];
  }

  /**
   * Displays a form to edit an existing Region entity.
   *
   * @Route("/{id}/edit", name="region_edit")
   */
  public function editAction($id)
  {
    $region = $this->findRegion($id);

    $editForm   = $this->createForm(RegionType::class, $region);
    $deleteForm = $this->createDeleteForm($id);

    return $this->render('region/edit.html.twig',
      [
        'title'  => 'Regions',
        'region' => $region,
        'edit_form'   => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
      ]);
  }

  /**
   * Edits an existing Region entity.
   *
   * @Route("/{id}/update", name="region_update")
   * @Template("region/edit.html.twig")
   */
  public function updateAction(Request $request, $id)
  {
    $region = $this->findRegion($id);

    $editForm   = $this->createForm(RegionType::class, $region);
    $deleteForm = $this->createDeleteForm($id);

    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {

      $this->regionRepository->em->persist($region);
      $this->regionRepository->em->flush();

      return $this->redirectToRoute('region_edit', ['id' => $id]);
    }

    return [
      'title'  => 'Regions',
      'region' => $region,
      'edit_form'   => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ];
  }

  /**
   * Deletes a Region entity.
   *
   * @Route("/{id}/delete", name="region_delete", methods={"POST"})
   */
  public function deleteAction(Request $request, $id)
  {
    $form = $this->createDeleteForm($id);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $region = $this->findRegion($id);

      $this->regionRepository->em->remove($region);
      $this->regionRepository->em->flush();
    }

    return $this->redirectToRoute('region');
  }

  private function createDeleteForm($id)
  {
    return $this->createFormBuilder(array('id' => $id))
      ->add('id', HiddenType::class)
      ->getForm();
  }
}
