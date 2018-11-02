<?php

declare(strict_types = 1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Form\ProjectDeleteType;
use App\Repository\ProjectRepository;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
 * Project controller.
 *
 * @Route("/project")
 */
class ProjectController extends AbstractController
{
  private $title = 'Projects';

  /** @var ProjectRepository */
  private $projectRepository;

  public function __construct(ProjectRepository $projectRepository)
  {
    $this->projectRepository = $projectRepository;
  }

  /**
   * Lists all Project entities.
   *
   * @Route("/list", name="project_list")
   * @Template()
   */
  public function indexAction()
  {
    $projects = $this->projectRepository->findAllOrderedByDate();

    return $this->render('project/list.html.twig',
    [
      'title'    => $this->title,
      'projects' => $projects,
    ]);
  }

  /**
   * Finds and displays a Project entity.
   *
   * @Route("/show/{id}", name="project_show")
   */
  public function showAction(Project $project)
  {
    $deleteForm = $this->createForm(ProjectDeleteType::class, $project);

    return $this->render('project/show.html.twig',
      [
        'title'   => $this->title,
        'project' => $project,
        'delete_form' => $deleteForm->createView(),
      ]);
  }

  /**
   * Creates a new Project entity.
   *
   * @Route("/create", name="project_create")
   */
  public function createAction(Request $request)
  {
    $project = new Project();
    $form = $this->createForm(ProjectType::class, $project);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->projectRepository->em->persist($project);
      $this->projectRepository->em->flush();

      return $this->redirectToRoute('project_update', ['id' => $project->getId()]);
    }
    return $this->render('project/create.html.twig',
      [
        'title'   => $this->title,
        'project' => $project,
        'form'    => $form->createView(),
      ]);
  }

  /**
   * Edits an existing Project entity.
   *
   * @Route("/update/{id}", name="project_update")
   */
  public function updateAction(Request $request, Project $project)
  {
    $updateForm = $this->createForm(ProjectType::class,       $project);
    $deleteForm = $this->createForm(ProjectDeleteType::class, $project);

    $updateForm->handleRequest($request);

    if ($updateForm->isSubmitted() && $updateForm->isValid()) {
      $this->projectRepository->em->persist($project);
      $this->projectRepository->em->flush();

      return $this->redirectToRoute('project_update', ['id' => $project->getId()]);
    }

    return $this->render('project/update.html.twig',
      [
        'title'       => $this->title,
        'project'     => $project,
        'update_form' => $updateForm->createView(),
        'delete_form' => $deleteForm->createView(),
      ]);
  }

  /**
   * Deletes a Project entity.
   *
   * @Route("/delete/{id}", name="project_delete")
   */
  public function deleteAction(Request $request, Project $project)
  {
    $form = $this->createForm(ProjectDeleteType::class, $project);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->projectRepository->em->remove($project);
      $this->projectRepository->em->flush();
    }

    return $this->redirectToRoute('project_list');
  }

  /**
   * Exports Project entities.
   *
   * @Route("/export.csv", name="project_export_csv")
   *
   * Given that there was no csv template file I don't think this was ever used
   */
  public function exportCsvAction()
  {
    /*
    $repository = $this->getDoctrine()->getRepository('SchedulerBundle:Project');
    $query = $repository->createQueryBuilder('s');
    $query->orderBy('s.start_date', 'ASC'); // TODO: order by end date

    $data = $query->getQuery()->getResult();
    $filename = "projects-" . date("Ymd_His") . ".csv";

    $response = $this->render('SchedulerBundle:Project:export.csv.twig', array('data' => $data));
    $response->headers->set('Content-Type', 'text/csv');

    $response->headers->set('Content-Disposition', 'attachment; filename=' . $filename);
    return $response;
    */
  }
}
