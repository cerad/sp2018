<?php

declare(strict_types = 1);

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use App\Entity\Location;
use App\Repository\LocationRepository;
use App\Form\LocationType;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
 * Location controller.
 *
 * @Route("/location")
 */
class LocationController extends AbstractController
{
  /** @var LocationRepository */
  private $locationRepository;

  public function __construct(LocationRepository $locationRepository)
  {
    $this->locationRepository = $locationRepository;
  }
  private function findLocation(int $id)
  {
    $location = $this->locationRepository->find($id);
    if (!$location) {
      throw $this->createNotFoundException('Unable to find Location entity.');
    }
    return $location;
  }
  /**
   * Lists all Location entities.
   *
   * @Route("/", name="location")
   * @Template()
   */
  public function indexAction()
  {
    $locations = $this->locationRepository->findAllOrderedByName();

    return array(
      'title' => 'Locations',
      'entities' => $locations,
    );
  }

  /**
   * Finds and displays a Location entity.
   *
   * @Route("/{id}/show", name="location_show")
   * @Template()
   */
  public function showAction(int $id)
  {
    $location = $this->findLocation($id);

    $deleteForm = $this->createDeleteForm($id);

    return array(
      'title' => 'Show Location',
      'entity' => $location,
      'delete_form' => $deleteForm->createView(),
      'map_key' => $this->getParameter('google_map_key'),
    );
  }

  /**
   * Redirects to google maps based on Location entity.
   *
   * @Route("/redirect/{id}", name="location_redirect")
   * @Template()
   */
  public function mapRedirectAction(int $id)
  {
    $location = $this->findLocation($id);

    //$locationData = "{$location->getLatitude()},{$location->getLongitude()} ({$location->getLongname()})";

    return $this->redirect(
      'https://maps.google.com/maps?q=' .
      urlencode(
        $location->getLatitude() . ',' . $location->getLongitude() . ' (' . $location->getLongname() . ')') . '&hl=en&t=h&z=19');
  }

  /**
   * Displays a form to create a new Location entity.
   *
   * @Route("/new", name="location_new")
   * @Template()
   */
  public function newAction()
  {
    $location = new Location();
    $form = $this->createForm(LocationType::class, $location);

    return array(
      'title'  => 'New Location',
      'entity' => $location,
      'form'   => $form->createView(),
    );
  }

  /**
   * Clone one entity to make a new Location entity.
   *
   * @Route("/{id}/clone", name="location_clone")
   * @Template("location/new.html.twig")
   */
  public function cloneAction(int $id)
  {
    $location = $this->findLocation($id);

    // reset id so persist will create a new instance.
    $location->resetForClone();

    $form = $this->createForm(LocationType::class, $location);

    return array(
      'title'  => 'Clone Location',
      'entity' => $location,
      'form'   => $form->createView(),
    );
  }

  /**
   * Creates a new Location entity.
   *
   * @Route("/create", name="location_create", methods={"POST"})
   * @Template("location/new.html.twig")
   */
  public function createAction(Request $request)
  {
    $location = new Location();
    $form = $this->createForm(LocationType::class, $location);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $this->locationRepository->em->persist($location);
      $this->locationRepository->em->flush();

      return $this->redirectToRoute('location_show', ['id' => $location->getId()]);
    }

    return array(
      'entity' => $location,
      'form' => $form->createView(),
    );
  }

  /**
   * Displays a form to edit an existing Location entity.
   *
   * @Route("/{id}/edit", name="location_edit")
   * @Template()
   */
  public function editAction(int $id)
  {
    $location = $this->findLocation($id);

    $editForm = $this->createForm(LocationType::class, $location);
    $deleteForm = $this->createDeleteForm($id);

    return array(
      'title'  => 'Edit Location',
      'entity' => $location,
      'edit_form'   => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Edits an existing Location entity.
   *
   * @Route("/{id}/update", name="location_update", methods={"POST"})
   * @Template("location/edit.html.twig")
   */
  public function updateAction(Request $request, int $id)
  {
    $location = $this->findLocation($id);

    $deleteForm = $this->createDeleteForm($id);
    $editForm   = $this->createForm(LocationType::class, $location);

    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {

      $this->locationRepository->em->persist($location);
      $this->locationRepository->em->flush();

      return $this->redirectToRoute('location_edit', ['id' => $id]);
    }

    return array(
      'entity'      => $location,
      'edit_form'   => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Deletes a Location entity.
   *
   * @Route("/{id}/delete", name="location_delete", methods={"POST"})
   */
  public function deleteAction(Request $request, int $id)
  {
    $form = $this->createDeleteForm($id);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $location = $this->findLocation($id);

      $this->locationRepository->em->remove($location);
      $this->locationRepository->em->flush ();
    }

    return $this->redirectToRoute('location');
  }

  private function createDeleteForm(int $id)
  {
    return $this->createFormBuilder(['id' => $id])
      ->add('id', HiddenType::class)
      ->getForm();
  }

  /**
   * Exports Location entities.
   *
   * @Route("/export.csv", name="location_export_csv")
   */
  public function exportCsvAction()
  {
    $data = $this->locationRepository->findAllOrderedByName();

    $filename = "locations-" . date("Ymd_His") . ".csv";

    $response = $this->render('location/export.csv.twig', array('data' => $data));

    $response->headers->set('Content-Type', 'text/csv');

    $response->headers->set('Content-Disposition', 'attachment; filename=' . $filename);

    return $response;
  }
}
