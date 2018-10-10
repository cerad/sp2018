<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use App\Entity\Enquiry;
use App\Form\EnquiryType;

class PageController extends AbstractController
{
  /**
   * Home page.
   *
   * @Route("/", name="scheduler_homepage")
   * @Template()
   */
  public function indexAction()
  {
    return [];
  }

  /**
   * Help page.
   *
   * @Route("/help", name="help")
   * @Template()
   */
  public function helpAction()
  {
    return [];
  }

  /**
   * Help sub-pages.
   *
   * @Route("/help/{topic}", name="help_topic")
   * @Template()
   */
  public function helpTopicAction($topic)
  {
    $topic = preg_replace('/[^0-9a-zA-Z_]/', '', $topic);
    return $this->render("page/help.$topic.html.twig");
  }

  /**
   * Contact page.
   *
   * @Route("/contact", name="scheduler_contact")
   * @Template()
   */
  public function contactAction(Request $request, \Swift_Mailer $mailer)
  {
    $enquiry = new Enquiry();
    $form = $this->createForm(EnquiryType::class, $enquiry);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      // send an email
      $message = (new \Swift_Message())
        ->setSubject('Contact enquiry from Sportac.us')
        ->setFrom($this->getParameter('scheduler.contact.emails.from'))
        ->setTo($this->getParameter('scheduler.contact.emails.to'))
        ->setBody($this->renderView('page/contactEmail.txt.twig', ['enquiry' => $enquiry]));

      $mailer->send($message);

      $this->addFlash('contact-notice', 'Your contact enquiry was successfully sent. Thank you!');

      // Redirect - This is important to prevent users re-posting
      // the form if they refresh the page
      return $this->redirect($this->generateUrl('scheduler_contact'));
    }
    return ['form' => $form->createView()];
  }
}

